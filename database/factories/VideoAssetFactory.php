<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VideoAsset>
 */
class VideoAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now                = time();
        $mediaAvailableDate = $this->faker->unixTime('now');

        //calculate the end date, between now and 7 days in future
        $expiryDateStart     = $now;
        $expiryDateEnd       = $now + (7 * 24 * 60 * 60); //7 days from now
        $mediaExpirationDate = $this->faker->numberBetween($expiryDateStart, $expiryDateEnd);

        return [
            'title'                 => $this->faker->sentence(),
            'description'           => $this->faker->text(),
            'guid'                  => $this->faker->uuid(),
            'media_available_date'  => $mediaAvailableDate,
            'media_expiration_date' => $mediaExpirationDate,
        ];
    }
}
