<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->increments('produce_id');
            $table->string('product_name');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('supplier_id');
            $table->integer('discount_id');
            $table->text('produce_desc');
            $table->float('product_price')->nullable();
            $table->string('product_img');
            $table->integer('product_quanity');
            $table->integer('product_status');
            $table->integer('product_expire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_product');
    }
}
