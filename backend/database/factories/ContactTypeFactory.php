<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['E-mail', 'Telefone', 'WhatsApp']),
        ];
    }
}
