<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LabRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'delivered_by',
        'department_id',
        'user_id',
        'request_date',
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
     * Get the user that owns the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The labSamples that belong to the LabRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labSamples(): BelongsToMany
    {
        return $this->belongsToMany(LabSample::class, 'lab_request_lab_sample', 'lab_request_id', 'lab_sample_id');
    }
}
