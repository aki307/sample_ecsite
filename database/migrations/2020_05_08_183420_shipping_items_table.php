<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned()->index();
            $table->integer('quantity');
            $table->integer('sale_price');
            $table->integer('shipping_id')->unsigned()->index();
            $table->timestamps();
            
            //外部キー制約
            $table->foreign('shipping_id')->references('id')->on('shippings');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_items');
    }
}
