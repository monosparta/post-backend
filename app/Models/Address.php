<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'zip_code',
        'region',
        'address_line_1',
        'address_line_2',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
