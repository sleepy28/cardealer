<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('resignations', function (Blueprint $table) {
             
            $table->unsignedBigInteger('approved_by')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('resignations', function (Blueprint $table) {
            $table->dropColumn('approved_by');
        });
    }
};