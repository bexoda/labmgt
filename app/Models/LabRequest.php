<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LabRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'department_id',
        'request_date',
        'delivered_by',
        'time_delivered',
        'sample_number',
        'received_by',
        'time_received',
        'prepared_by',
        'time_prepared',
        'production_date',
        'date_reported',
        'weighed_by',
        'digested_by',
        'entered_by',
        'titration_by',
        'plant_source_id',
        'description',
    ];

    /**
     * Get the client that owns the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }


    /**
     * Get the department that owns the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the plantSource that owns the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plantSource(): BelongsTo
    {
        return $this->belongsTo(PlantSource::class);
    }

    /**
     * Get the user that owns the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the labResults for the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labResults(): HasMany
    {
        return $this->hasMany(LabResult::class);
    }
}
