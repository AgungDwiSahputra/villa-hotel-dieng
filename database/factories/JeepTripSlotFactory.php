<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JeepTrip\JeepTripSlot>
 */
class JeepTripSlotFactory extends Factory
{
    protected $model = \App\Models\JeepTrip\JeepTripSlot::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jeep_trip_id' => function () {
                return \Database\Factories\JeepTripFactory::new()->create()->id;
            },
            'nama_slot' => $this->faker->randomElement(['Pagi', 'Siang', 'Sore', 'Full Day']),
            'jam_mulai' => $this->faker->time('H:i:s'),
            'jam_selesai' => $this->faker->time('H:i:s'),
            'is_active' => true,
        ];
    }
}
