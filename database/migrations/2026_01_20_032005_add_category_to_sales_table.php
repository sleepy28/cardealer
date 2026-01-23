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
    Schema::table('sales', function (Blueprint $table) {
        
        
        if (!Schema::hasColumn('sales', 'price')) {
            
            
            $table->decimal('price', 15, 2)->default(0)->after('buyer_name');
        }

        
        if (!Schema::hasColumn('sales', 'commission')) {
            $table->decimal('commission', 15, 2)->default(0)->after('price');
        }
    });
}

    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn(['price', 'commission']);
    });
}
};
