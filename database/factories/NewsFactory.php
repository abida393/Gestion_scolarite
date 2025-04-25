<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence, // Random sentence as the title
            'content' => $this->faker->paragraph, // Random paragraph for the content
            'image' => $this->faker->imageUrl(640, 480, 'news', true), // Random image URL for the news image
            'date_news' => $this->faker->date(), // Random date for the news date
        ];
    }
}
