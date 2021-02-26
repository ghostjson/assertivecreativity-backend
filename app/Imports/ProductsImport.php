<?php

namespace App\Imports;

use App\Models\StockProduct;
use Illuminate\Routing\Route;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ProductsImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return StockProduct::updateOrCreate(
            ['product_id' => $row['ProductID']],
            [
                'product_id' => $row['ProductID'],
                'product_key' => $row['ProductKey'],
                'variant_id' => $row['ItemNum'],
                'name' => $row['Name'],
                'cat_year' => $row['CatYear'],
                'expiration_date' => $row['ExpirationDate'],
                'discontinued' => $row['Discontinued'],
                'category' => $row['Cat1Name'],
                'tag' => $row['Tag'],
                'images' => json_encode([$row['Image1URL'], $row['Image2URL'], $row['Image3URL']]),
                'description' => $row['Description'],
                'themes' => $row['Themes'],
                'colors' => $row['Colors'],
                'keywords' => $row['Keywords'],
                'dimension_list' => json_encode([$row['Dimension1'], $row['Dimension2'], $row['Dimension3']]),
                'dimension_unit_list' => json_encode([$row['Dimension1Units'], $row['Dimension2Units'], $row['Dimension3Units']]),
                'dimension_type_list' => json_encode([$row['Dimension1Type'], $row['Dimension2Type'], $row['Dimension3Type']]),
                'quantity_step' => $row['QtyStep'],
                'quantities_list' => json_encode([$row['Qty1'], $row['Qty2'], $row['Qty3'], $row['Qty4'], $row['Qty5'], $row['Qty6']]),
                'price_list' => json_encode([$row['Prc1'], $row['Prc2'], $row['Prc3'], $row['Prc4'], $row['Prc5'], $row['Prc6']]),
                'pr_code' => $row['PrCode'],
                'pieces_per_unit_list' => json_encode([$row['PiecesPerUnit1'], $row['PiecesPerUnit2'], $row['PiecesPerUnit3'], $row['PiecesPerUnit4'], $row['PiecesPerUnit5'], $row['PiecesPerUnit6']]),
                'quote_upon_request' => $row['QuoteUponRequest'],
                'price_include_clr' => $row['PriceIncludeClr'],
                'price_include_side' => $row['PriceIncludeSide'],
                'price_include_loc' => $row['PriceIncludeLoc'],
                'setup_chg' => $row['SetupChg'],
                'setup_chg_code' => $row['SetupChgCode'],
                'screen_chg' => $row['ScreenChg'],
                'screen_chg_code' => $row['ScreenChgCode'],
                'plate_chg' => $row['PlateChg'],
                'plate_chg_code' => $row['PlateChgCode'],
                'die_chg' => $row['DieChg'],
                'die_chg_code' => $row['DieChgCode'],
                'tooling_chg' => $row['ToolingChg'],
                'tooling_chg_code' => $row['ToolingChgCode'],
                'repeat_chg' => $row['RepeatChg'],
                'repeat_chg_code' => $row['RepeatChgCode'],
                'add_clr_chg' => $row['AddClrChg'],
                'add_clr_chg_code' => $row['AddClrChgCode'],
                'add_clr_run_chg_list' => json_encode([$row['AddClrRunChg1'], $row['AddClrRunChg2'], $row['AddClrRunChg3'], $row['AddClrRunChg4'], $row['AddClrRunChg5'], $row['AddClrRunChg6']]),
                'add_clr_run_chg_code' => $row['AddClrRunChgCode'],
                'is_recyclable' => $row['IsRecyclable'],
                'is_environmentally_friendly' => $row['IsEnvironmentallyFriendly'],
                'is_new_prod' => $row['IsNewProd'],
                'not_suitable' => $row['NotSuitable'],
                'exclusive' => $row['Exclusive'],
                'hazardous' => $row['Hazardous'],
                'officially_licensed' => $row['OfficiallyLicensed'],
                'is_food' => $row['IsFood'],
                'is_clothing' => $row['IsClothing'],
                'imprint_size_list' => json_encode([$row['ImprintSize1'], $row['ImprintSize2']]),
                'imprint_size_units_list' => json_encode([$row['ImprintSize1Units'], $row['ImprintSize2Units']]),
                'imprint_size_type_list' => json_encode([$row['ImprintSize1Type'], $row['ImprintSize2Type']]),
                'imprint_loc' => $row['ImprintLoc'],
                'second_imprint_size_list' => json_encode([$row['SecondImprintSize1'], $row['SecondImprintSize1']]),
                'second_imprint_size_units_list' => json_encode([$row['SecondImprintSize1Units'], $row['SecondImprintSize1Units']]),
                'second_imprint_size_type_list' => json_encode([$row['SecondImprintSize1Type'], $row['SecondImprintSize1Type']]),
                'second_imprint_loc' => $row['SecondImprintLoc'],
                'decoration_method' => $row['DecorationMethod'],
                'no_decoration' => $row['NoDecoration'],
                'made_in_country' => $row['MadeInCountry'],
                'assembled_in_country' => $row['AssembledInCountry'],
                'decorated_in_country' => $row['DecoratedInCountry'],
                'compliance_list' => $row['ComplianceList'],
                'warning_lbl' => $row['WarningLbl'],
                'compliance_memo' => $row['ComplianceMemo'],
                'prod_time_lo' => $row['ProdTimeLo'],
                'prod_time_hi' => $row['ProdTimeHi'],
                'rush_prod_time_lo' => $row['RushProdTimeLo'],
                'rush_prod_time_hi' => $row['RushProdTimeHi'],
                'packaging' => $row['Packaging'],
                'carton_l' => $row['CartonL'],
                'carton_w' => $row['CartonW'],
                'carton_h' => $row['CartonH'],
                'weight_per_carton' => $row['WeightPerCarton'],
                'units_per_carton' => $row['UnitsPerCarton'],
                'ship_point_country' => $row['ShipPointCountry'],
                'ship_point_zip' => $row['ShipPointZip'],
                'comment' => $row['Comment'],
                'verified' => $row['Verified'],
                'update_inventory' => $row['UpdateInventory'],
                'inventory_on_hand' => $row['InventoryOnHand'],
                'inventory_on_hand_add' => $row['InventoryOnHandAdd'],
                'inventory_memo' => $row['InventoryMemo'],
                'owner' => auth()->id()
            ]
        );
    }

    public function headingRow(): int{
        return 7;
    }

    public function startRow() : int
    {
        return 8;
    }
}
