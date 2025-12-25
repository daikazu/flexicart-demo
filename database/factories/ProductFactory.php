<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 9.99, 299.99),
            'image' => null,
            'category' => fake()->randomElement(['Electronics', 'Clothing', 'Books', 'Home', 'Sports']),
            'taxable' => true,
            'variants' => null,
            'active' => true,
        ];
    }

    public function withVariants(): static
    {
        return $this->state(fn (array $attributes): array => [
            'variants' => [
                'colors' => ['Black', 'White', 'Blue'],
                'sizes' => ['S', 'M', 'L', 'XL'],
            ],
        ]);
    }

    public function nonTaxable(): static
    {
        return $this->state(fn (array $attributes): array => [
            'taxable' => false,
        ]);
    }
}
