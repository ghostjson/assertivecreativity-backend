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
            'base_price' => $this->faker->numberBetween(100, 5000),
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'price_table' => '',
            'price_table_mode' => '',
            'sales' => $this->faker->numberBetween(0, 200),
            'serial' => $this->faker->uuid,
            'stock' => $this->faker->numberBetween(0, 1000),
            'custom_forms' => [[
                "id" => 0,
                "title" => "rgegdf",
                "parentForm" => null,
                "options" => [
                    [
                        "type" => "radioBtn",
                        "title" => "dfgdfg",
                        "name" => "Radio Buttons",
                        "meta" => [
                            "isChained" => false
                        ],
                        "inputs" => [
                            [
                                "label" => "dfgdfg",
                                "value" => "dfgdfg",
                                "chained_options" => [],
                                "selectedChainedOption" => null
                            ],
                            [
                                "label" => "dfgdfg",
                                "value" => "dfgdfg",
                                "chained_options" => [],
                                "selectedChainedOption" => null
                            ]
                        ]
                    ]
                ]
            ]],
            'category_id' => Category::all()->random()->id,
            'seller_id' => User::where('role_id', Role::getVendorRoleID())->get()->random()->id,
        ];
    }
}
