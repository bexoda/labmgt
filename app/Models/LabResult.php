<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lab_request_id',
        'user_id',
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
     * Get the user that owns the LabResult
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
