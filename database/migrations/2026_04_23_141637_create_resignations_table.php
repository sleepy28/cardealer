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
    Schema::create('resignations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->text('reason');
        $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');

        $table->unsignedBigInteger('approved_by')->nullable();
        $table->timestamps();


        $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::dropIfExists('resignations');
}
};
