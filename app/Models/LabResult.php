<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'time',
        'sampleId',
        'lab_request_id',
        'Mn',
        'Sol_Mn',
        'Fe',
        'B',
        'MnO2',
        'SiO2',
        'Al2O3',
        'P',
        'MgO',
        'CaO',
        'Au',
    ];

    /**
     * Get the labRequest that owns the LabResult
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function labRequest(): BelongsTo
    {
        return $this->belongsTo(LabRequest::class);
    }
}
