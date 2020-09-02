<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToShippingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_items', function (Blueprint $table) {
            $table->integer('money_transfer');
            $table->integer('delivery_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_items', function (Blueprint $table) {
            $table->integer('money_transfer');
            $table->integer('delivery_status');
        });
    }
}
