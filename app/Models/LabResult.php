<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabResult extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'sample_name',
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
     */
    public function labRequest(): BelongsTo
    {
        return $this->belongsTo(LabRequest::class);
    }
}
