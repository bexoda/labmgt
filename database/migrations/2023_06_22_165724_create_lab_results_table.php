<?php

use App\Models\User;
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
            $table->foreignId('lab_request_lab_sample_id');
            $table->foreignIdFor(User::class)->comment('AssayLab Staff who prepared lab results');
            $table->string('result_date');
            $table->string('Mn');
            $table->string('Sol_Mn');
            $table->string('Fe');
            $table->string('B');
            $table->string('MnO2');
            $table->string('SiO2');
            $table->string('Al2O3');
            $table->string('P');
            $table->string('MgO');
            $table->string('CaO');
            $table->string('Au');
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
