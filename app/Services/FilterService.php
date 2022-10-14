<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *   schema="FilterServiceParams",
 *   @OA\Property(
 *     property="page",
 *     type="integer",
 *     example=1,
 *   ),
 *   @OA\Property(
 *     property="pageSize",
 *     type="integer",
 *     example=5,
 *   ),
 *   @OA\Property(
 *     property="sorts",
 *     type="array",
 *     @OA\Items(
 *      type="object",
 *      example={"field": "id", "order": "asc"},
 *     ),
 *   ),
 * )
 */

class FilterService
{

    public function applyFilters($query, $filters)
    {
        // filters 格式
        // [
        //     'field' => 'name', // table 欄位，必填。  若目標為關聯表，則格式為 'relation.field'
        //     'operator' => '=', // 選填，若未填則預設為 like ，並且 vaLue 會自動在前後加上 %。
        //                            可使用任何 where 可識別的 operator 例如 >, <, >=, <=, !=, <>。
        //                            特別值 between ，搭配的 value 為長度二的陣列值，會使用 whereBetween 過濾。
        //                            特別值 group，搭配的 value 為一組 filters 陣列，會以 value 做聯集過濾。
        //     'value' => 'test', // 搜尋值，必填，若未填 operator 則會自動在前後加上 %
        // ],

        $query->when($filters, function ($query, $filters) {
            collect($filters)->each(function ($filter) use ($query) {

                $relations = explode('.', $filter['field']);
                $field = Str::snake(array_pop($relations));
                $relation = implode('.',  array_map(fn ($relation) =>  Str::snake($relation), $relations));

                $operator = array_key_exists('operator', $filter) ? $filter['operator'] ?? 'like' : 'like';
                $value = array_key_exists('operator', $filter) ? $filter['value'] : "%" . $filter['value'] . "%";



                switch ($operator) {
                    case 'between':
                        if (gettype($value) === 'array') {


                            if ($relation) {
                                $query->whereHas($relation, function ($query) use ($field, $value) {
                                    $query->whereBetween($field, $value);
                                });
                            } else {
                                $query->whereBetween($field, $value);
                            }
                        }
                        break;
                    case 'group':
                        if (gettype($value) === 'array') {

                            $query->where(function ($query) use ($field, $value, $relation) {
                                collect($value)->each(function ($filter, $index) use ($field, $query, $relation) {
                                    $operator = array_key_exists('operator', $filter) ? $filter['operator'] ?? 'like' : 'like';
                                    $value = array_key_exists('operator', $filter) ? $filter['value'] : "%" . $filter['value'] . "%";
                                    \Log::debug('=== group filter ===');
                                    \Log::debug($field . ',' . $operator . ',' . $relation);
                                    \Log::debug($value);


                                    if ($relation) {

                                        if ($index > 0) {
                                            $query->orWhereHas($relation, function ($query) use ($field, $operator, $value) {
                                                $operator === 'between' ? $query->whereBetween($field, $value) : $query->where($field, $operator, $value);
                                            });
                                        } else {
                                            $query->whereHas($relation, function ($query) use ($index, $field, $operator, $value) {
                                                \Log::debug('=== group filter value ===');
                                                $operator === 'between'  ? $query->whereBetween($field, $value) : $query->where($field, $operator, $value);
                                            });
                                        }
                                    } else {
                                        $operator === 'between'
                                            ? ($index === 0  ?  $query->whereBetween($field, $value) : $query->orWhereBetween($field, $value))
                                            : ($index === 0  ?  $query->where($field, $operator, $value) : $query->orWhere($field, $operator, $value));
                                    }
                                });
                            });
                        }
                        break;
                    default:
                        if ($relation) {
                            $query->whereHas($relation, function ($query) use ($field, $operator, $value) {
                                $query->where($field, $operator, $value);
                            });
                        } else {
                            $query->where($field, $operator, $value);
                        }

                        break;
                }
            });
        });

        return $query;
    }

    public function applySorts($query, $sorts)
    {
        return $query->when($sorts, function ($query, $sorts) {
            collect($sorts)->each(function ($sort) use ($query) {
                $field = Str::snake($sort['field']);
                $query->orderBy($field, $sort['order']);
            });
        });
    }
}
