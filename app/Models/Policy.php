<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_number',
        'holder_name',
        'type',
        'type_label',
        'coverage_limit',
        'annual_premium',
        'effective_date',
        'renewal_date',
        'status',
    ];
}
