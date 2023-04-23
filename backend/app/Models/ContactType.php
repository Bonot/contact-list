<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
    ];
}
