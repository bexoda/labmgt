<?php

use App\Models\User;
use App\Models\Client;
use App\Models\Department;
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
            $table->foreignIdFor(Client::class);
            $table->string('delivered_by')->nullable();
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(User::class)->comment('AssayLab Staff who received lab request');
            // $table->integer('number_samples');
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
