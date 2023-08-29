<?php

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
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LabRequest::class);
            $table->time('time');
            $table->string('sampleId');
            $table->string('Mn')->nullable();
            $table->string('Sol_Mn')->nullable();
            $table->string('Fe')->nullable();
            $table->string('B')->nullable();
            $table->string('MnO2')->nullable();
            $table->string('SiO2')->nullable();
            $table->string('Al2O3')->nullable();
            $table->string('P')->nullable();
            $table->string('MgO')->nullable();
            $table->string('CaO')->nullable();
            $table->string('Au')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
