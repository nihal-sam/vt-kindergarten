<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_name',
        'dob',
        'gender',
        'program',
        'parent_name',
        'relation',
        'phone',
        'email',
        'address',
        'previous_school',
        'message',
        'status',
        'notes',
    ];

    protected $casts = [
        'dob' => 'date',
    ];
}
