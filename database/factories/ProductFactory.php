<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Bezhanov\Faker\Provider\Commerce;
use Bezhanov\Faker\Provider\Avatar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name=$this->faker->unique(true)->productName;
        return [
            'name'=>$name,
            'category_id'=>Category::inRandomOrder()->first()->id,
            'store_id'=>Store::inRandomOrder()->first()->id,
            'slug'=>Str::slug($name),
            'description'=>$this->faker->text,
            'image'=>$this->faker->avatar,
            'price'=>$this->faker->randomFloat(1,100,499),
            'compare_price'=>$this->faker->randomFloat(1,500,999),
            'featured'=>rand(0,1),
            'quantity'=>fake()->numberBetween(10,100),


        ];
    }
}
