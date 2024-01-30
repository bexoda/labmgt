<?php

use App\Models\Client;
use App\Models\Department;
use App\Models\PlantSource;
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
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignIdFor(Client::class);
            $table->foreignIdFor(Department::class);
            $table->date('request_date');
            $table->string('delivered_by')->nullable();
            $table->dateTime('time_delivered');
            $table->integer('sample_number');
            $table->string('received_by')->nullable();
            $table->dateTime('time_received');
            $table->string('prepared_by')->nullable();
            $table->dateTime('time_prepared');
            $table->date('production_date');
            $table->date('date_reported');
            $table->string('weighed_by')->nullable();
            $table->string('digested_by')->nullable();
            $table->string('entered_by')->nullable();
            $table->string('titration_by')->nullable();
            $table->foreignIdFor(PlantSource::class)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_requests');
    }
};
