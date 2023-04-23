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
        $person1 = Person::factory()->create();
        $person2 = Person::factory()->create();

        Contact::factory()->email()->create([
            'person_id' => $person1->id
        ]);

        Contact::factory()->phone()->create([
            'person_id' => $person1->id
        ]);

        Contact::factory()->phone()->create([
            'person_id' => $person2->id
        ]);
    }
}
