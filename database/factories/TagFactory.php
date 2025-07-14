<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid'         => $this->faker->unique()->slug,
            'type'        => $this->faker->randomElement(['keyword', 'campaign', 'type', 'tone']),
            'section_id'  => $this->faker->optional(0.8)->word,
            'section_name' => $this->faker->optional(0.6)->word,
            'web_title'   => $this->faker->unique()->sentence(3),
            'web_url'     => $this->faker->unique()->url
        ];
    }
}
