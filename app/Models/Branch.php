<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    public function workingHours()
    {
        return $this->hasMany(BranchWorkingHour::class);
    }

}
