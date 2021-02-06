<?php

namespace App\Exports;

use App\Models\StockProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            [' ', ' '],
            [' ', ' '],
            [' ', ' '],
            [' ', ' '],
            [' '],
            [' '],
            $this->headers(),
            $this->sanitize(StockProduct::all()->toArray())
        ]);
    }

    public function sanitize(array $products)
    {
        foreach ($products as $product){
            $image_url_list = $product['image_url_list'];

            unset($product['image_url_list']);
        }
    }

    private function headers(){
        return [
            'ProductID',
            'ItemNum',
            'Name',
            'CatYear',
            'ExpirationDate',
            'Discontinued',
            'Cat1Name',
            'Tag',
            'Image1URL',
            'Image2URL',
            'Image3URL',
            'Themes',
            'Description',
            'Keywords',
            'Colors',
        ];
    }
}
