<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'department_slug',
    ];

    /**
     * Get all of the users for the Department
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all of the labRequests for the Department
     */
    public function labRequests(): HasMany
    {
        return $this->hasMany(LabRequest::class);
    }

    /**
     * Get all of the dailyReports for the Department
     */
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }
}
