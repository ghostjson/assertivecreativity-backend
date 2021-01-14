<?php

namespace App\Imports;

use App\Models\StockProduct;
use Illuminate\Routing\Route;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return StockProduct::updateOrCreate(
            ['product_id' => $row[0]],
            [
                'product_id' => $row[0],
                'variant_id' => $row[1],
                'name' => $row[2],
                'cat_year' => $row[3],
                'expiration_date' => $row[4],
                'discontinued' => $row[5],
                'category' => $row[6],
                'tag' => $row[7],
                'image_url_list' => json_encode([$row[8], $row[9], $row[10]]),
                'description' => $row[11],
                'themes' => $row[12],
                'colors' => $row[13],
                'keywords' => $row[14],
                'dimension_list' => json_encode([$row[15], $row[18], $row[21]]),
                'dimension_unit_list' => json_encode([$row[16], $row[19], $row[22]]),
                'dimension_type_list' => json_encode([$row[17], $row[21], $row[23]]),
                'quantities_list' => json_encode([$row[24], $row[25], $row[26], $row[27], $row[28], $row[29]]),
                'price_list' => json_encode([$row[30], $row[31], $row[32], $row[33], $row[34], $row[35]]),
                'pr_code' => $row[36],
                'pieces_per_unit_list' => json_encode([$row[37], $row[38], $row[39], $row[40], $row[41], $row[42]]),
                'quote_upon_request' => $row[43],
                'price_include_clr' => $row[44],
                'price_include_side' => $row[45],
                'price_include_loc' => $row[46],
                'setup_chg' => $row[47],
                'setup_chg_code' => $row[48],
                'screen_chg' => $row[49],
                'screen_chg_code' => $row[50],
                'plate_chg' => $row[51],
                'plate_chg_code' => $row[52],
                'die_chg' => $row[53],
                'die_chg_code' => $row[54],
                'tooling_chg' => $row[55],
                'tooling_chg_code' => $row[56],
                'repeat_chg' => $row[57],
                'repeat_chg_code' => $row[58],
                'add_clr_chg' => $row[59],
                'add_clr_chg_code' => $row[60],
                'add_clr_run_chg_list' => json_encode([$row[61], $row[62], $row[63], $row[64], $row[65], $row[66]]),
                'add_clr_run_chg_code' => $row[67],
                'is_recyclable' => $row[68],
                'is_environmentally_friendly' => $row[69],
                'is_new_product' => $row[70],
                'not_suitable' => $row[71],
                'exclusive' => $row[72],
                'hazardous' => $row[73],
                'officially_licensed' => $row[74],
                'is_food' => $row[75],
                'is_clothing' => $row[76],
                'imprint_size_list' => json_encode([$row[77], $row[80]]),
                'imprint_size_units_list' => json_encode([$row[78], $row[81]]),
                'imprint_size_type_list' => json_encode([$row[79], $row[82]]),
                'imprint_loc' => $row[83],
                'second_imprint_size_list' => json_encode([$row[84], $row[87]]),
                'second_imprint_units_list' => json_encode([$row[85], $row[88]]),
                'second_imprint_type_list' => json_encode([$row[86], $row[89]]),
                'second_imprint_loc' => $row[90],
                'decoration_method' => $row[91],
                'no_decoration' => $row[92],
                'made_in_country' => $row[93],
                'assembled_in_country' => $row[94],
                'decorated_in_country' => $row[95],
                'compliance_list' => $row[96],
                'warning_lbl' => $row[97],
                'compliance_memo' => $row[98],
                'prod_time_lo' => $row[99],
                'prod_time_hi' => $row[100],
                'rush_prod_time_lo' => $row[101],
                'rush_prod_time_hi' => $row[102],
                'packing' => $row[103],
                'carton_l' => $row[104],
                'carton_w' => $row[105],
                'carton_h' => $row[106],
                'weight_per_carton' => $row[107],
                'units_per_carton' => $row[108],
                'ship_point_country' => $row[109],
                'ship_point_zip' => $row[110],
                'comment' => $row[111],
                'verified' => $row[112],
                'update_inventory' => $row[113],
                'inventory_on_hand' => $row[114],
                'inventory_on_hand_added' => $row[115],
                'inventory_memo' => $row[116],
                'owner' => auth()->id()
            ]
        );
    }

    public function startRow() : int
    {
        return 8;
    }
}
