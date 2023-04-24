<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Contact;
use App\Models\ContactType;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_create_contact_with_valid_data()
    {
        $typeEmail = ContactType::factory()->create(['type' => 'E-mail']);
        $typePhone = ContactType::factory()->create(['type' => 'Telefone']);

        $data = [
            'name' => fake()->unique()->name(),
            'contacts' => [
                [
                    'contact_type_id' => $typeEmail->id,
                    'value' => fake()->unique()->email(),
                ],
                [
                    'contact_type_id' => $typePhone->id,
                    'value' => fake()->unique()->phoneNumber(),
                ],
            ],
        ];

        $response = $this->post('/api/contacts-list', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Contato criado com sucesso!',
                'data' => [
                    'name' => $data['name'],
                    'contacts' => [
                        [
                            'contact_type_id' => 1,
                            'value' => $data['contacts'][0]['value'],
                        ],
                        [
                            'contact_type_id' => 2,
                            'value' => $data['contacts'][1]['value'],
                        ],
                    ],
                ],
            ]);

        $this->assertDatabaseHas('persons', [
            'name' => $data['name'],
        ]);

        $person = Person::where('name', $data['name'])->first();

        $this->assertDatabaseHas('contacts', [
            'person_id' => $person->id,
            'contact_type_id' => $data['contacts'][0]['contact_type_id'],
            'value' => $data['contacts'][0]['value'],
        ]);

        $this->assertDatabaseHas('contacts', [
            'person_id' => $person->id,
            'contact_type_id' => $data['contacts'][1]['contact_type_id'],
            'value' => $data['contacts'][1]['value'],
        ]);
    }

    public function test_create_contact_with_invalid_data()
    {
        $type = ContactType::factory()->create();

        $data = [
            'name' => '',
            'contacts' => [
                [
                    'contact_type_id' => $type->id,
                    'value' => '',
                ],
            ],
        ];

        $response = $this->postJson('/api/contacts-list', $data);

        $response->assertJson([
                'success' => false,
                'status' => 422,
                'errors' => [
                    'name' => ['Informe um nome.'],
                ],
            ]);

        $this->assertDatabaseMissing('persons', [
            'name' => $data['name'],
        ]);

        $this->assertDatabaseMissing('contacts', [
            'contact_type_id' => $data['contacts'][0]['contact_type_id'],
            'value' => $data['contacts'][0]['value'],
        ]);
    }

    public function test_show_person_with_contacts()
    {
        $person = Person::factory()->create();
        $type = ContactType::factory()->create(['type' => 'Telefone']);

        $contact1 = Contact::factory()->create([
            'person_id' => $person->id,
            'contact_type_id' => $type->id,
            'value' => '(48) 988888888',
        ]);

        $contact2 = Contact::factory()->create([
            'person_id' => $person->id,
            'contact_type_id' => $type->id,
            'value' => '(48) 999999999',
        ]);

        $response = $this->get('/api/contacts-list/' . $person->id);

        $response->assertStatus(201);
        $response->assertJson([
            'id' => $person->id,
            'name' => $person->name,
            'contacts' => [
                [
                    'id' => $contact1->id,
                    'contact_type_id' => $contact1->contact_type_id,
                    'value' => $contact1->value,
                ],
                [
                    'id' => $contact2->id,
                    'contact_type_id' => $contact2->contact_type_id,
                    'value' => $contact2->value,
                ],
            ],
        ]);
    }

    public function test_contact_update()
    {
        $contact = Contact::factory()->email()->create();
        $requestData = [
            'name' => 'Ana Maria',
            'contacts' => [
                [
                    'id' => $contact->id,
                    'person_id' => $contact->person_id,
                    'contact_type_id' => $contact->contact_type_id,
                    'value' => 'example@example.com.br',
                ],
            ],
        ];

        $response = $this->put("/api/contacts-list/{$contact->person->id}", $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Contato atualizado com sucesso!',
                'data' => [
                    'name' => $requestData['name'],
                    'contacts' => [
                        [
                            'contact_type_id' => $contact->contact_type_id,
                            'value' => $requestData['contacts'][0]['value'],
                        ],
                    ],
                ],
            ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'value' => 'example@example.com.br',
        ]);

        $this->assertDatabaseHas('persons', [
            'id' => $contact->person->id,
            'name' => 'Ana Maria',
        ]);
    }

    public function test_contact_destroy()
    {
        $contact = Contact::factory()->phone()->create();

        $response = $this->delete('/api/contacts-list/' . $contact->person->id);

        $response->assertStatus(204);

        $this->assertSoftDeleted($contact);

        $this->assertSoftDeleted($contact->person);
    }
}
