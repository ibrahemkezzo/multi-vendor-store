<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Provider\en_US\Company;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name=$this->faker->unique(true)->company;
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'description'=>fake()->sentence(10),
            'logo_image'=>fake()->imageUrl(300,300),
            'cover_image'=>fake()->imageUrl(600,800),


        ];
    }
}
