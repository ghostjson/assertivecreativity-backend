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

            $table->string('ProductID')->unique();
            $table->string('ItemNum');
            $table->string('Name');
            $table->integer('CatYear')->nullable();
            $table->date('ExpirationDate')->nullable();
            $table->boolean('Discontinued')->nullable();
            $table->string('Cat1Name')->nullable();
            $table->string('Cat2Name')->nullable();
            $table->string('Page1')->nullable();
            $table->string('Page2')->nullable();
            $table->text('Description')->nullable();
            $table->string('Keywords')->nullable();
            $table->string('Colors')->nullable();
            $table->string('Themes')->nullable();
            $table->integer('Dimension1')->nullable();
            $table->integer('Dimension1Units')->nullable();
            $table->integer('Dimension1Type')->nullable();
            $table->integer('Dimension2')->nullable();
            $table->integer('Dimension2Units')->nullable();
            $table->integer('Dimension2Type')->nullable();
            $table->integer('Dimension3')->nullable();
            $table->integer('Dimension3Units')->nullable();
            $table->integer('Dimension3Type')->nullable();
            $table->integer('Qty1')->nullable();
            $table->integer('Qty2')->nullable();
            $table->integer('Qty3')->nullable();
            $table->integer('Qty4')->nullable();
            $table->integer('Qty5')->nullable();
            $table->integer('Qty6')->nullable();
            $table->integer('Prc1')->nullable();
            $table->integer('Prc2')->nullable();
            $table->integer('Prc3')->nullable();
            $table->integer('Prc4')->nullable();
            $table->integer('Prc5')->nullable();
            $table->integer('Prc6')->nullable();
            $table->string('PrCode')->nullable();
            $table->integer('PiecesPerUnit1')->nullable();
            $table->integer('PiecesPerUnit2')->nullable();
            $table->integer('PiecesPerUnit3')->nullable();
            $table->integer('PiecesPerUnit4')->nullable();
            $table->integer('PiecesPerUnit5')->nullable();
            $table->integer('PiecesPerUnit6')->nullable();
            $table->boolean('QuoteUponRequest')->nullable();
            $table->string('PriceIncludeClr')->nullable();
            $table->string('PriceIncludeSide')->nullable();
            $table->string('PriceIncludeLoc')->nullable();
            $table->string('SetupChg')->nullable();
            $table->string('SetupChgCode')->nullable();
            $table->string('ScreenChg')->nullable();
            $table->string('ScreenChgCode')->nullable();
            $table->string('PlateChg')->nullable();
            $table->string('PlateChgCode')->nullable();
            $table->string('DieChg')->nullable();
            $table->string('DieChgCode')->nullable();
            $table->string('ToolingChg')->nullable();
            $table->string('ToolingChgCode')->nullable();
            $table->string('RepeatChg')->nullable();
            $table->string('RepeatChgCode')->nullable();
            $table->string('AddClrChg')->nullable();
            $table->string('AddClrChgCode')->nullable();
            $table->string('AddClrRunChg1')->nullable();
            $table->string('AddClrRunChg2')->nullable();
            $table->string('AddClrRunChg3')->nullable();
            $table->string('AddClrRunChg4')->nullable();
            $table->string('AddClrRunChg5')->nullable();
            $table->string('AddClrRunChg6')->nullable();
            $table->string('AddClrRunChgCode')->nullable();
            $table->boolean('IsRecyclable')->nullable();
            $table->boolean('IsEnvironmentallyFriendly')->nullable();
            $table->boolean('IsNewProd')->nullable();
            $table->boolean('NotSuitable')->nullable();
            $table->boolean('Exclusive')->nullable();
            $table->boolean('Hazardous')->nullable();
            $table->boolean('OfficiallyLicensed')->nullable();
            $table->boolean('IsFood')->nullable();
            $table->boolean('IsClothing')->nullable();
            $table->string('ImprintSize1')->nullable();
            $table->string('ImprintSize1Units')->nullable();
            $table->string('ImprintSize1Type')->nullable();
            $table->string('ImprintSize2')->nullable();
            $table->string('ImprintSize2Units')->nullable();
            $table->string('ImprintSize2Type')->nullable();
            $table->string('ImprintLoc')->nullable();
            $table->string('SecondImprintSize1')->nullable();
            $table->string('SecondImprintSize1Units')->nullable();
            $table->string('SecondImprintSize1Type')->nullable();
            $table->string('SecondImprintSize2')->nullable();
            $table->string('SecondImprintSize2Units')->nullable();
            $table->string('SecondImprintSize2Type')->nullable();
            $table->string('SecondImprintLoc')->nullable();
            $table->string('DecorationMethod')->nullable();
            $table->boolean('NoDecoration')->nullable();
            $table->boolean('NoDecorationOffered')->nullable();
            $table->string('NewPictureURL')->nullable();
            $table->string('NewPictureFile')->nullable();
            $table->boolean('ErasePicture')->nullable();
            $table->string('NewBlankPictureURL')->nullable();
            $table->boolean('NewBlankPictureFile')->nullable();
            $table->boolean('EraseBlankPicture')->nullable();
            $table->boolean('NotPictured')->nullable();
            $table->string('MadeInCountry')->nullable();
            $table->string('AssembledInCountry')->nullable();
            $table->string('DecoratedInCountry')->nullable();
            $table->string('ComplianceList')->nullable();
            $table->string('WarningLbl')->nullable();
            $table->string('ComplianceMemo')->nullable();
            $table->string('ProdTimeLo')->nullable();
            $table->string('ProdTimeHi')->nullable();
            $table->string('RushProdTimeLo')->nullable();
            $table->integer('RushProdTimeHi')->nullable();
            $table->integer('Packaging')->nullable();
            $table->string('CartonL')->nullable();
            $table->string('CartonW')->nullable();
            $table->string('CartonH')->nullable();
            $table->string('WeightPerCarton')->nullable();
            $table->string('UnitsPerCarton')->nullable();
            $table->string('ShipPointCountry')->nullable();
            $table->string('ShipPointZip')->nullable();
            $table->string('Comment')->nullable();
            $table->string('Verified')->nullable();
            $table->string('UpdateInventory')->nullable();
            $table->string('InventoryOnHand')->nullable();
            $table->string('InventoryOnHandAdd')->nullable();
            $table->string('InventoryMemo')->nullable();

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
