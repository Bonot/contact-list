<?php

namespace Database\Factories;

use App\Models\ContactType;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'person_id' => fn () => Person::factory()->create(),
        ];
    }

    public function email(): self
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'contact_type_id' => ContactType::factory()->create(['type' =>'E-mail']),
                'value' => fake()->unique()->email(),
            ]);
        });
    }

    public function phone(): self
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'contact_type_id' => ContactType::factory()->create(['type' =>'Telefone']),
                'value' => fake()->unique()->phoneNumber(),
            ]);
        });
    }

    public function emailForSeed(): self
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'contact_type_id' => ContactType::where('type','E-mail')->first()->getKey(),
                'value' => fake()->unique()->email(),
            ]);
        });
    }

    public function phoneForSeed(): self
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'contact_type_id' => ContactType::where('type','Telefone')->first()->getKey(),
                'value' => fake()->unique()->phoneNumber(),
            ]);
        });
    }
}
