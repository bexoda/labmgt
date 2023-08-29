<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'location',
    ];


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
