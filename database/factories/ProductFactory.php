<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'basePrice' => $this->faker->numberBetween(100, 5000),
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'priceTable' => '',
            'priceTableMode' => '',
            'sales' => $this->faker->numberBetween(0, 200),
            'serial' => $this->faker->uuid,
            'stock' => $this->faker->numberBetween(0, 1000),
            'customForms' => '[{"id":0,"title":"Enter Order Specifications","parentForm":null,"options":[{"type":"color","title":"Enter the color of the scarf","name":"Colors","meta":{"isChained":false},"inputs":[{"label":"Violet","value":"#c70b84","chainedOptions":[{"type":"dropdown","title":"Select A pattern","name":"Dropdown Selection","meta":{"isChained":true},"inputs":[{"label":"Plain","value":"plain"},{"label":"Patterned","value":"patterned"}]}],"selectedChainedOption":null},{"label":"Greenish","value":"#42bf10","chainedOptions":[{"type":"dropdown","title":"Select a pattern","name":"Dropdown Selection","meta":{"isChained":true},"inputs":[{"label":"Plain","value":"plain"},{"label":"Checkered","value":"checkered"}]}],"selectedChainedOption":null}]},{"type":"dropdown","title":"Select a size","name":"Dropdown Selection","meta":{"isChained":false},"inputs":[{"label":"Large","value":"large","chainedOptions":[],"selectedChainedOption":null},{"label":"Medium","value":"medium","chainedOptions":[],"selectedChainedOption":null},{"label":"Small","value":"small","chainedOptions":[],"selectedChainedOption":null}]}]},{"id":1,"title":"Enter Delivery Instructions","parentForm":null,"options":[{"type":"radioBtn","title":"Select type of location","name":"Radio Buttons","meta":{"isChained":false},"inputs":[{"label":"Home (9 AM to 9 PM delivery)","value":"home-(9-am-to-9-pm-delivery)","chainedOptions":[],"selectedChainedOption":null},{"label":"Office (10 AM to 5 PM delivery)","value":"office-(10-am-to-5-pm-delivery)","chainedOptions":[],"selectedChainedOption":null}]},{"type":"text","title":"Enter any further instructions for delivery","name":"Text input","meta":{"isChained":false},"inputs":[{"label":"Enter instructions","chainedOptions":[],"selectedChainedOption":null},{"label":null,"chainedOptions":[],"selectedChainedOption":null},{"label":null,"chainedOptions":[],"selectedChainedOption":null}]}]}]',
            'category' => Category::all()->random()->id,
            'seller_id' => User::where('role_id', Role::getVendorRoleID())->get()->random()->id,
        ];
    }
}
