<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->sentence(mt_rand(6,10));
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1,9999),
            'excerpt' => $this->faker->paragraph(2),
            'image' => 'article' . $this->faker->numberBetween(1,4) . '.jpg',
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '</p>',
        ];
    }
}
