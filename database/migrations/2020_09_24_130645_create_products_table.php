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
        Schema::create('stock_products', function (Blueprint $table) {
            $table->id();

            $table->string('product_id')->unique();
            $table->string('variant_id');
            $table->string('name');
            $table->integer('cat_year')->nullable();
            $table->date('expiration_date')->nullable();
            $table->boolean('discontinued')->nullable();
            $table->string('category')->nullable();
            $table->string('image_url_list')->nullable();
            $table->string('tag')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('colors')->nullable();
            $table->string('themes')->nullable();
            $table->integer('dimension_list')->nullable();
            $table->integer('dimension_unit_list')->nullable();
            $table->integer('dimension_type_list')->nullable();
            $table->integer('quantity_step')->nullable();
            $table->integer('quantities_list')->nullable();
            $table->integer('price_list')->nullable();
            $table->string('pr_code')->nullable();
            $table->integer('pieces_per_unit_list')->nullable();
            $table->boolean('quote_upon_request')->nullable();
            $table->string('price_include_clr')->nullable();
            $table->string('price_include_side')->nullable();
            $table->string('price_include_loc')->nullable();
            $table->string('setup_chg')->nullable();
            $table->string('setup_chg_code')->nullable();
            $table->string('screen_chg')->nullable();
            $table->string('screen_chg_code')->nullable();
            $table->string('plate_chg')->nullable();
            $table->string('plate_chg_code')->nullable();
            $table->string('die_chg')->nullable();
            $table->string('die_chg_code')->nullable();
            $table->string('tooling_chg')->nullable();
            $table->string('tooling_chg_code')->nullable();
            $table->string('repeat_chg')->nullable();
            $table->string('repeat_chg_code')->nullable();
            $table->string('add_clr_chg')->nullable();
            $table->string('add_clr_chg_code')->nullable();
            $table->string('add_clr_run_chg_list')->nullable();
            $table->string('add_clr_run_chg_code')->nullable();
            $table->boolean('is_recyclable')->nullable();
            $table->boolean('is_environmentally_friendly')->nullable();
            $table->boolean('is_new_prod')->nullable();
            $table->boolean('not_suitable')->nullable();
            $table->boolean('exclusive')->nullable();
            $table->boolean('hazardous')->nullable();
            $table->boolean('officially_licensed')->nullable();
            $table->boolean('is_food')->nullable();
            $table->boolean('is_clothing')->nullable();
            $table->string('imprint_size_list')->nullable();
            $table->string('imprint_size_units_list')->nullable();
            $table->string('imprint_size_type_list')->nullable();
            $table->string('imprint_loc')->nullable();
            $table->string('second_imprint_size_list')->nullable();
            $table->string('second_imprint_size_units_list')->nullable();
            $table->string('second_imprint_size_type_list')->nullable();
            $table->string('second_imprint_loc')->nullable();
            $table->string('decoration_method')->nullable();
            $table->boolean('no_decoration')->nullable();
            $table->string('made_in_country')->nullable();
            $table->string('assembled_in_country')->nullable();
            $table->string('decorated_in_country')->nullable();
            $table->string('compliance_list')->nullable();
            $table->string('warning_lbl')->nullable();
            $table->string('compliance_memo')->nullable();
            $table->string('prod_time_lo')->nullable();
            $table->string('prod_time_hi')->nullable();
            $table->string('rush_prod_time_lo')->nullable();
            $table->integer('rush_prod_time_hi')->nullable();
            $table->integer('packaging')->nullable();
            $table->string('carton_l')->nullable();
            $table->string('carton_w')->nullable();
            $table->string('carton_h')->nullable();
            $table->string('weight_per_carton')->nullable();
            $table->string('units_per_carton')->nullable();
            $table->string('ship_point_country')->nullable();
            $table->string('ship_point_zip')->nullable();
            $table->string('comment')->nullable();
            $table->string('verified')->nullable();
            $table->string('update_inventory')->nullable();
            $table->string('inventory_on_hand')->nullable();
            $table->string('inventory_on_hand_add')->nullable();
            $table->string('inventory_memo')->nullable();

            $table->bigInteger('owner')->unsigned();

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
