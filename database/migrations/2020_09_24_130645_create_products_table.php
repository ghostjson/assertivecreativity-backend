<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('basePrice');
            $table->string('description');
            $table->string('image');
            $table->json('priceTable')->nullable();
            $table->boolean('priceTableMode');
            $table->integer('sales');
            $table->string('serial')->unique();
            $table->integer('stock');
            $table->json('customForms')->nullable();

            $table->bigInteger('category')->unsigned();
            $table->bigInteger('seller_id')->unsigned();

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
        Schema::dropIfExists('products');
    }
}
