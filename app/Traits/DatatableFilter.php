<?php

namespace App\Traits;

trait DatatableFilter
{

    public function scopeDatatable($query, $filters, $sorts, $pageSize)
    {

        $filterService = \App::make(\App\Services\FilterService::class);

        $query = $filterService->applyFilters($query, $filters);
        $query = $filterService->applySorts($query, $sorts);

        \Log::debug('==== query ====   ' . $query->toSql());

        return $query->paginate($pageSize ?? 10);
    }


    public function relateDatatable($relation, $filters, $sorts, $pageSize)
    {

        $filterService = \App::make(\App\Services\FilterService::class);
        $query = $this->$relation();
        $query = $filterService->applyFilters($query, $filters);
        $query = $filterService->applySorts($query, $sorts);

        \Log::debug('==== query ====   ' . $query->toSql());
        return  $query->paginate($pageSize ?? 10);
    }
}
