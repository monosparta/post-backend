<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relationship',
        'mobile_country_code',
        'mobile_country_calling_code',
        'mobile',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
