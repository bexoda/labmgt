<?php

use App\Models\LabSample;
use App\Models\LabRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lab_samples', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('lab_request_lab_sample', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LabRequest::class);
            $table->foreignIdFor(LabSample::class);
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_samples');
        Schema::dropIfExists('lab_request_lab_sample');

    }
};
