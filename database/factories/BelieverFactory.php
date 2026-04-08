<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Believer;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Believer>
 */
class BelieverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Believer::class;

    public function definition(): array
    {
        $genders = Believer::genders();
        $maritalStatus = Believer::maritalStatus();

        // $baptized = $this->faker->randomElement($baptismStatuses);
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-1 years')->format('Y-m-d');
        $marriage_date = $this->faker->dateTimeBetween('-80 years', '-1 years')->format('Y-m-d');
        // $arrivalYear = $this->faker->numberBetween(1990, now()->year);

        return [
            'lastname' => $this->faker->lastName(),
            'firstname' => $this->faker->firstName(),
            'gender' => $this->faker->randomElement($genders),
            'marital_status' => $this->faker->randomElement($maritalStatus),
            'marriage_date' => $marriage_date,
            'spouse_name' => $this->faker->name(),
            'birth_date' => $birthDate,
            'birth_place' => $this->faker->city(),
            'ethnicity' => $this->faker->word(),
            'nationality' => $this->faker->country(),
            'number_of_children' => $this->faker->numberBetween(0, 5),
            'cni_number' => strtoupper(Str::random(10)),
        ];
    }
}
