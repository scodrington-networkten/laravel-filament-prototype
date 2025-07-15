<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid'       => $this->faker->unique()->slug,
            'web_title' => $this->faker->unique()->sentence(3),
            'web_url'   => $this->faker->unique()->url,
            'editions'  => $this->getEditionData()
        ];
    }

    /**
     * Edition data is an array of objects
     *
     * @return array|null
     */
    protected function getEditionData(): array|null
    {
        $count = $this->faker->numberBetween(0, 3);
        //simulate no editions, null response
        if ($count === 0)
            return null;

        $editions = [];
        for ($i = 1; $i <= $count; $i++) {
            $editions[] = [
                'uid'       => $this->faker->slug(),
                'web_title' => $this->faker->sentence(3),
                'web_url'   => $this->faker->url,
                'code'      => 'default'
            ];
        }

        return $editions;
    }
}
