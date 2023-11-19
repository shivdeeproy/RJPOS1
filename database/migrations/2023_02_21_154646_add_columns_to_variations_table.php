<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variations', function (Blueprint $table) {
            $table->decimal('mrp_inc_tax',22,4)->after('sell_price_inc_tax')->nullable();

            $table->decimal('mrp_exc_tax',22,4)->after('mrp_inc_tax')->nullable();

            $table->decimal('discount',22,4)->after('mrp_exc_tax')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variations', function (Blueprint $table) {
                       $table->dropColumn('mrp_inc_tax');
                       $table->dropColumn('mrp_exc_tax');
                       $table->dropColumn('discount');



        });
    }
}
