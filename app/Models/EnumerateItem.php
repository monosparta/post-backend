<?php

namespace App\Models;

use App\Traits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnumerateItem extends Model
{
    use HasFactory;
    use Traits\DataTableFilter;

    protected $fillable = [
        'name',
        'title',
        'value',
        'value_alt',
        'value_alt_2',
        'sequence',
        'is_enabled'
    ];

    public function enumerate()
    {
        return $this->belongsTo(Enumerate::class);
    }

    public function upSequence()
    {
        $this->sequence = $this->sequence - 1;
        $this->save();
    }

    public function downSequence()
    {
        $this->sequence = $this->sequence + 1;
        $this->save();
    }
}
