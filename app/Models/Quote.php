<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_ref',
        'name',
        'email',
        'phone',
        'type',
        'type_label',
        'coverage',
        'premium',
        'location',
        'zip_code',
        'status',
        'notes',
    ];
}
