<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'gender_id',
        'date_of_birth',
        'phone_number',
        'location',
    ];

    /**
     * Get the gender that owns the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Get all of the labRequests for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labRequests(): HasMany
    {
        return $this->hasMany(LabRequest::class);
    }
}
