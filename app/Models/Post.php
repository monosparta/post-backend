<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use UuidTrait;
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value, 'UTC')->tz('Asia/Taipei')->format('Y-m-d H:i:s'),
        );
    }
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value, 'UTC')->tz('Asia/Taipei')->format('Y-m-d H:i:s'),
        );
    }
    public function user()
    {
        return $this->belongsTo(AdminUser::class);
    }

}
