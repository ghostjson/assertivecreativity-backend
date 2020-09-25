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
            'customForms' => '',
            'category' => Category::all()->random()->id,
            'seller_id' => User::where('role_id', Role::getVendorRoleID())->get()->random()->id,
        ];
    }
}
