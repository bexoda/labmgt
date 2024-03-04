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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Mn' => 'decimal:2',
        'Sol_Mn' => 'decimal:2',
        'Fe' => 'decimal:2',
        'B' => 'decimal:2',
        'MnO2' => 'decimal:2',
        'SiO2' => 'decimal:2',
        'Al2O3' => 'decimal:2',
        'P' => 'decimal:2',
        'MgO' => 'decimal:2',
        'CaO' => 'decimal:2',
        'Au' => 'decimal:2',
    ];

}
