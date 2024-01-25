<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchWorkingHour extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'start_time', 'end_time', 'closed','date'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
