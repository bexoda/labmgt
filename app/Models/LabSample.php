<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LabSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
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
