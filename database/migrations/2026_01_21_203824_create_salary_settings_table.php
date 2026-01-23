<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('salary_settings', function (Blueprint $table) {
        $table->id();
        $table->string('role')->unique(); 
        $table->double('base_salary');    
        $table->double('overtime_rate')->default(500);
        $table->integer('threshold_hours')->default(12);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_settings');
    }
};
