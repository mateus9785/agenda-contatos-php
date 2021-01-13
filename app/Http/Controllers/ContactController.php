<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Phone;
use App\Models\Address;
use App\Models\Group;
use App\Models\ContactGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $group_id = $request->group_id;
        $search = $request->search;
        $per_page = $request->per_page ?? 10;

        $query = DB::table('contacts')->where('contacts.user_id', $user_id);
        if($search)
            $query->where('contacts.name', 'like', '%'.$search.'%');

        if($group_id)
            $query->join('contact_groups', function($join) use ($group_id) {
                $join->on('contacts.id', '=', 'contact_groups.contact_id')
                    ->where('contact_groups.group_id', $group_id);
            });
        
        $contacts = $query->orderBy('name', 'ASC')
            ->paginate($per_page);

        $groups = Group::where('user_id', $user_id)
            ->orderBy('name', 'ASC')
            ->get();

        $contacts_names =  Contact::pluck('name');

        return view('contact.grid', [
            'contacts' => $contacts,
            'groups' => $groups,
            'contacts_names' => $contacts_names
        ]);
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $user_id = Auth::user()->id;

        $groups = Group::where('user_id', $user_id)
            ->orderBy('name', 'ASC')
            ->get();

        $provinces_ibge = file_get_contents('http://www.geonames.org/childrenJSON?geonameId=3469034');
        $provinces = array_map(function ($province) {
            return $province->adminCodes1->ISO3166_2;
        }, json_decode($provinces_ibge)->geonames);

        if ($id) {
            $contact = Contact::where([
                'contacts.id' => $id,
                'contacts.user_id' => $user_id
            ])->first();

            if (!$contact)
                return response("Contato não encontrado", 404);

            $contact_groups = ContactGroup::where('contact_id', $contact->id)
                ->join('groups', function($join) {
                    $join->on('contact_groups.group_id', '=', 'groups.id');
                })->get();
            
            $phones = Phone::where('contact_id', $contact->id)->get();
            $addresses = Address::where('contact_id', $contact->id)->get();

            return view('contact.form', [
                "groups" => $groups,
                "contact" => [
                    "data" => $contact,
                    "contact_groups" => $contact_groups,
                    "phones" => $phones,
                    "addresses" => $addresses,
                ],
                "provinces" => $provinces
            ]);
        }

        return view('contact.form', [
            "groups" => $groups,
            "contact" => [
                "data" => [],
                "contact_groups" => [],
                "phones" => [],
                "addresses" => [],
            ],
            "provinces" => $provinces
        ]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $contact = Contact::create([
            'user_id' => $user_id,
            "name" => $request->name,
            "name_file" => $request->name_file,
            "is_user_contact" => false
        ]);

        foreach ($request->groups as $id) {
            ContactGroup::create([
                'user_id' => $user_id,
                "contact_id" => $contact->id,
                "group_id" => $id,
            ]);
        }

        foreach ($request->phones as $name) {
            Phone::create([
                'name' => $name,
                "contact_id" => $contact->id,
            ]);
        }

        foreach ($request->addresses as $address) {
            Address::create([
                'street' => $address["street"],
                'neighborhood' => $address["neighborhood"],
                'city' => $address["city"],
                'province' => $address["province"],
                'complement' => $address["complement"],
                'cep' => $address["cep"],
                'number' => $address["number"],
                'contact_id' => $contact->id,
            ]);
        }

        return response($contact, 200);
    }

    public function update(Request $request, int $id)
    {
        $user_id = Auth::user()->id;
        $contact = Contact::where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();

        if (!$contact)
            return response("Contato não encontrado", 404);


        $contact->update([
            "name" => $request->name,
            "name_file" => $request->name_file
        ]);

        ContactGroup::where('contact_id', $contact->id)->delete();

        foreach ($request->groups as $id) {
            ContactGroup::create([
                'user_id' => $user_id,
                "contact_id" => $contact->id,
                "group_id" => $id,
            ]);
        }

        Phone::where('contact_id', $contact->id)->delete();

        foreach ($request->phones as $name) {
            Phone::create([
                'name' => $name,
                "contact_id" => $contact->id,
            ]);
        }

        Address::where('contact_id', $contact->id)->delete();

        foreach ($request->addresses as $address) {
            Address::create([
                'street' => $address["street"],
                'neighborhood' => $address["neighborhood"],
                'city' => $address["city"],
                'province' => $address["province"],
                'complement' => $address["complement"],
                'cep' => $address["cep"],
                'number' => $address["number"],
                'contact_id' => $contact->id,
            ]);
        }

        return response($contact, 200);
    }

    public function destroy(int $id)
    {
        $user_id = Auth::user()->id;
        $contact = Contact::where([
            'id' => $id,
            'user_id' => $user_id
        ])->first();

        if (!$contact)
            return response("Contato não encontrado", 404);

        ContactGroup::where('contact_id', $contact->id)->delete();
        Phone::where('contact_id', $contact->id)->delete();
        Address::where('contact_id', $contact->id)->delete();

        $contact->delete();

        return response([], 200);
    }
}
