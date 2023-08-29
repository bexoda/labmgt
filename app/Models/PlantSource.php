<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlantSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the labRequests for the PlantSource
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labRequests(): HasMany
    {
        return $this->hasMany(LabRequest::class);
    }
}
