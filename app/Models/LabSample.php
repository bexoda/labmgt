<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabSample extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    /**
     * The labRequests that belong to the LabSample
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labRequests(): BelongsToMany
    {
        return $this->belongsToMany(LabRequest::class, 'lab_request_lab_sample', 'lab_sample_id', 'lab_request_id');
    }
}
