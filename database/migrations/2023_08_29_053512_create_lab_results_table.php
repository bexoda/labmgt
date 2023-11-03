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
            $table->string('sample_name');
            $table->decimal('Mn')->nullable();
            $table->decimal('Sol_Mn')->nullable();
            $table->decimal('Fe')->nullable();
            $table->decimal('B')->nullable();
            $table->decimal('MnO2')->nullable();
            $table->decimal('SiO2')->nullable();
            $table->decimal('Al2O3')->nullable();
            $table->decimal('P')->nullable();
            $table->decimal('MgO')->nullable();
            $table->decimal('CaO')->nullable();
            $table->decimal('Au')->nullable();
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
