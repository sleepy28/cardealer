<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        
        if (!Schema::hasColumn('sales', 'commission')) {
            
            Schema::table('sales', function (Blueprint $table) {
                $table->decimal('commission', 15, 2)->default(0)->after('sale_price'); 
                
            });
        }
    }

    public function down()
    {
        
        if (Schema::hasColumn('sales', 'commission')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('commission');
            });
        }
    }
};