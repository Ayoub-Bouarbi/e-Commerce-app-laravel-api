<?php

namespace Database\Factories;

use App\Models\Product;
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
            'sku' => uniqid(),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'quantity' => rand(1,1000),
            'weight' => rand(4,50)/10,
            'price' => rand(30,1500)/10,
            'sale_price' => 0,
            'status' => $this->faker->boolean,
            'featured' => $this->faker->boolean,
            'brand_id' => rand(1,10)
        ];
    }
}
