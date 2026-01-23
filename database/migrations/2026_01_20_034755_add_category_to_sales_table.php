<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            
            
            if (!Schema::hasColumn('sales', 'category')) {
                $table->string('category')->nullable()->after('vehicle_model');
            }

            
            if (!Schema::hasColumn('sales', 'price')) {
                $table->decimal('price', 15, 2)->default(0)->after('buyer_name');
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('sales', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};