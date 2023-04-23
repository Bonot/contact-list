<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'contact_type_id',
        'value'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function contactType(): BelongsTo
    {
        return $this->belongsTo(ContactType::class);
    }
}
