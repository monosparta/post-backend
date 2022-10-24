<?php

namespace App\Models;

use App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enumerate extends Model
{
    use HasFactory;
    use Traits\DatatableFilter;
    protected $table = 'enumerate';
    protected $fillable = [
        'name',
        'title',
        'description',
        'default_value',
        'is_enabled',
    ];

    public function enumerateItems()
    {
        return $this->hasMany(EnumerateItem::class);
    }
}
