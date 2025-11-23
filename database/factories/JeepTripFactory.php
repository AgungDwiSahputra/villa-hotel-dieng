<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JeepTrip\JeepTrip>
 */
class JeepTripFactory extends Factory
{
    protected $model = \App\Models\JeepTrip\JeepTrip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => 'JT-' . $this->faker->unique()->numberBetween(1000, 9999),
            'slug' => $this->faker->unique()->slug(),
            'nama_paket' => $this->faker->sentence(3),
            'deskripsi_singkat' => $this->faker->sentence(),
            'deskripsi_lengkap' => $this->faker->paragraphs(3, true),
            'zona' => $this->faker->randomElement(['Dieng', 'Borobudur', 'Merapi', 'Merbabu']),
            'durasi_jam' => $this->faker->numberBetween(2, 8),
            'kapasitas_ideal_per_jeep' => 4,
            'kapasitas_max_per_jeep' => 4,
            'harga_weekday' => $this->faker->numberBetween(300000, 800000),
            'harga_weekend' => $this->faker->numberBetween(400000, 1000000),
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'is_active' => true,
        ];
    }
}
