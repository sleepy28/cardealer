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
    Schema::create('payroll_payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); 
        $table->date('start_date'); 
        $table->date('end_date');   
        $table->boolean('is_paid')->default(false);
        $table->string('paid_by_name')->nullable(); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_payments');
    }
};
