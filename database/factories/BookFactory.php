<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'author' => fake()->name(),
            'isbn' => fake()->numerify('###-###-####'),
            'published_year' => fake()->numberBetween(1900, date('Y')),
            'cover_image' => 'images/fFfvgSTLbp2oGAfF4GeOIKk9TgHI6cTEfOcR25Ok.jpg', // Có thể thêm logic tạo ảnh mẫu sau
            'price' => fake()->randomFloat(2, 10, 100),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(['available', 'out_of_stock', 'discontinued']),
        ];
    }
}
