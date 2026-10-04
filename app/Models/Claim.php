<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_number',
        'policy_number',
        'claimant_name',
        'incident_description',
        'estimated_loss',
        'assigned_adjuster',
        'priority',
        'status',
    ];
}
