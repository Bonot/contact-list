<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactType;
use App\Models\Person;
use Illuminate\Database\Seeder;

class ContactListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 15; $i++) {
            $person = Person::factory()->create();

            Contact::factory()->emailForSeed()->create([
                'person_id' => $person->id
            ]);

            Contact::factory()->phoneForSeed()->create([
                'person_id' => $person->id
            ]);
        }
    }
}
