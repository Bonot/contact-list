<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactListRequest;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactListController extends Controller
{
    public function index(Request $request)
    {
        $persons = Person::with('contacts.contactType')
            ->orderBy('name')
            ->paginate($request->get('limit') ?: 10);

        $persons->getCollection()->transform(function ($person) {
            return $this->makeContactResponse($person);
        });

        $response = [
            'data' => $persons->getCollection(),
            'current_page' => $persons->currentPage(),
            'per_page' => $persons->perPage(),
            'total' => $persons->total(),
        ];

        if ($persons->hasMorePages()) {
            $response['next_page_url'] = $persons->nextPageUrl();
        }

        if ($persons->previousPageUrl()) {
            $response['prev_page_url'] = $persons->previousPageUrl();
        }

        return $response;
    }

    public function getContactTypes()
    {
        return ContactType::query()
            ->get();
    }

    public function store(ContactListRequest $request)
    {
        DB::beginTransaction();

        $data = $request->all();

        try {
            $person = Person::create([
                'name' => $data['name'],
            ]);

            foreach ($data['contacts'] as $contact) {
                Contact::create([
                    'person_id' => $person->getKey(),
                    'contact_type_id' => $contact['contact_type_id'],
                    'value' => $contact['value'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Contato criado com sucesso!',
                'data' => $this->getPersonWhithContacts($person->getKey()),
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erro ao criar contato!',
            ], 500);
        }
    }

    public function show(int $person)
    {
        return response()->json($this->getPersonWhithContacts($person), 201);
    }

    public function update(int $person, ContactListRequest $request)
    {
        $person = Person::findOrFail($person);

        DB::beginTransaction();

        $data = $request->all();

        try {
            $person->name = $data['name'];
            $person->save();
            $keepIds = [];

            foreach ($data['contacts'] as $contact) {
                $updateContact = Contact::findOrNew($contact['id'] ?? null);
                $updateContact->person_id = $person->getKey();
                $updateContact->contact_type_id = $contact['contact_type_id'];
                $updateContact->value = $contact['value'];
                $updateContact->save();
                $keepIds[] = $updateContact->getKey();
            }

            Contact::where('person_id', $person->getKey())
                ->whereNotIn('id', $keepIds);

            DB::commit();

            return response()->json([
                'message' => 'Contato criado com sucesso!',
                'data' => $this->getPersonWhithContacts($person->getKey()),
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao criar contato!',
            ], 500);
        }
    }

    public function destroy(int $person)
    {
        $pessoa = Person::findOrFail($person);
        $pessoa->delete();

        return response()->json(['message' => 'Contato removido com sucesso']);
    }

    private function getPersonWhithContacts(int $personId)
    {
        $person = Person::with('contacts.contactType')
        ->where('id', $personId)
        ->first();

        return $this->makeContactResponse($person);
    }

    private function makeContactResponse(Person $person)
    {
        return [
            'id' => $person->id,
            'name' => $person->name,
            'contacts' => $person->contacts->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'person_id' => $contact->person_id,
                    'contact_type_id' => $contact->contact_type_id,
                    'contact_type' => $contact->contactType->type,
                    'value' => $contact->value,
                ];
            }),
        ];
    }
}
