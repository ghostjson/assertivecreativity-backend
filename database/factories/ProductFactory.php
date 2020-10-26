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
            'image' => 'mock.jpeg',
            'price_table' => '',
            'price_table_mode' => '',
            'sales' => $this->faker->numberBetween(0, 200),
            'serial' => $this->faker->uuid,
            'stock' => $this->faker->numberBetween(0, 1000),
            'custom_forms' => array (
                        0 =>
                            array (
                                'id' => 0,
                                'title' => 'Product Customisation',
                                'is_formgroup' => true,
                                'parent_form' => NULL,
                                'options' =>
                                    array (
                                    ),
                            ),
                        1 =>
                            array (
                                'id' => 1,
                                'title' => 'Cloth Customisation',
                                'is_formgroup' => false,
                                'parent_form' => 0,
                                'options' =>
                                    array (
                                        0 =>
                                            array (
                                                'type' => 'color',
                                                'title' => 'Pick a color',
                                                'name' => 'Colors',
                                                'meta' =>
                                                    array (
                                                        'isChained' => false,
                                                    ),
                                                'inputs' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'label' => 'Reddish',
                                                                'value' => '#e83c1a',
                                                                'chained_options' =>
                                                                    array (
                                                                        0 =>
                                                                            array (
                                                                                'type' => 'dropdown',
                                                                                'title' => 'Cloth Pattern',
                                                                                'name' => 'Dropdown Selection',
                                                                                'meta' =>
                                                                                    array (
                                                                                        'isChained' => true,
                                                                                    ),
                                                                                'inputs' =>
                                                                                    array (
                                                                                        0 =>
                                                                                            array (
                                                                                                'label' => 'Plain',
                                                                                                'value' => 'plain',
                                                                                            ),
                                                                                        1 =>
                                                                                            array (
                                                                                                'label' => 'Checkered',
                                                                                                'value' => 'checkered',
                                                                                            ),
                                                                                        2 =>
                                                                                            array (
                                                                                                'label' => 'Dots',
                                                                                                'value' => 'dots',
                                                                                            ),
                                                                                    ),
                                                                            ),
                                                                    ),
                                                                'selectedChainedOption' => 'dropdown',
                                                            ),
                                                        1 =>
                                                            array (
                                                                'label' => 'Bluish',
                                                                'value' => '#3639d1',
                                                                'chained_options' =>
                                                                    array (
                                                                        0 =>
                                                                            array (
                                                                                'type' => 'dropdown',
                                                                                'title' => 'Cloth Pattern',
                                                                                'name' => 'Dropdown Selection',
                                                                                'meta' =>
                                                                                    array (
                                                                                        'isChained' => true,
                                                                                    ),
                                                                                'inputs' =>
                                                                                    array (
                                                                                        0 =>
                                                                                            array (
                                                                                                'label' => 'Plain',
                                                                                                'value' => 'plain',
                                                                                            ),
                                                                                        1 =>
                                                                                            array (
                                                                                                'label' => 'Checkered',
                                                                                                'value' => 'checkered',
                                                                                            ),
                                                                                        2 =>
                                                                                            array (
                                                                                                'label' => 'Dots',
                                                                                                'value' => 'dots',
                                                                                            ),
                                                                                    ),
                                                                            ),
                                                                    ),
                                                                'selectedChainedOption' => 'dropdown',
                                                            ),
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'type' => 'text',
                                                'title' => 'Enter additional remarks for cloth customisation.',
                                                'name' => 'Text input',
                                                'meta' =>
                                                    array (
                                                        'isChained' => false,
                                                    ),
                                                'inputs' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'label' => 'Enter remarks here',
                                                                'chained_options' =>
                                                                    array (
                                                                    ),
                                                                'selectedChainedOption' => NULL,
                                                            ),
                                                    ),
                                            ),
                                    ),
                            ),
                        2 =>
                            array (
                                'id' => 2,
                                'title' => 'Delivery Instruction',
                                'is_formgroup' => false,
                                'parent_form' => NULL,
                                'options' =>
                                    array (
                                        0 =>
                                            array (
                                                'type' => 'radioBtn',
                                                'title' => 'Type of address',
                                                'name' => 'Radio Buttons',
                                                'meta' =>
                                                    array (
                                                        'isChained' => false,
                                                    ),
                                                'inputs' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'label' => 'Home (9 AM to 9 PM)',
                                                                'value' => 'home-(9-am-to-9-pm)',
                                                                'chained_options' =>
                                                                    array (
                                                                    ),
                                                                'selectedChainedOption' => NULL,
                                                            ),
                                                        1 =>
                                                            array (
                                                                'label' => 'Work (9 AM to 4 PM)',
                                                                'value' => 'work-(9-am-to-4-pm)',
                                                                'chained_options' =>
                                                                    array (
                                                                    ),
                                                                'selectedChainedOption' => NULL,
                                                            ),
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
            'category_id' => Category::all()->random()->id,
            'seller_id' => User::where('role_id', Role::getVendorRoleID())->get()->random()->id,
        ];
    }
}
