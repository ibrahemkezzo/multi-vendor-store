<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Bezhanov\Faker\Provider\Commerce;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name=$this->faker->unique(true)->department;
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'description'=>fake()->sentence(10),
            'image'=>fake()->imageUrl(),
           
        ];
    }
}
