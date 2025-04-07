<?php

namespace Database\Factories;

use App\Models\Conference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conference>
 */
class ConferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conference::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = $this->faker->numberBetween(2020, 2030);
        $startDate = $this->faker->dateTimeBetween("$year-01-01", "$year-06-30");
        $endDate = $this->faker->dateTimeBetween($startDate, "$year-12-31");

        return [
            'year' => $year,
            'name' => 'Conference ' . $year,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(20),
        ];
    }

    /**
     * Indicate that the conference is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }
}
