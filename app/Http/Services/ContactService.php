<?php

namespace App\Http\Services;

use App\Http\Services\ContactServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\ContactRepositoryInterface;
use App\Http\Repositories\AddressRepositoryInterface;
use App\Http\Repositories\ContactGroupRepositoryInterface;
use App\Http\Repositories\PhoneRepositoryInterface;
use App\Http\Repositories\GroupRepositoryInterface;

class ContactService implements ContactServiceInterface
{
    public function __construct(
        ContactRepositoryInterface $contactRepository,
        AddressRepositoryInterface $addressRepository,
        ContactGroupRepositoryInterface $contactGroupRepository,
        PhoneRepositoryInterface $phoneRepository,
        GroupRepositoryInterface $groupRepository
    ){
        $this->contactRepository = $contactRepository;
        $this->addressRepository = $addressRepository;
        $this->contactGroupRepository = $contactGroupRepository;
        $this->phoneRepository = $phoneRepository;
        $this->groupRepository = $groupRepository;
    }

    public function index($group_id, $search, $per_page = 10){
        $user_id = Auth::user()->id;

        $contacts = $this->contactRepository->findAllPaginate($user_id, $group_id, 
            $search, $per_page);

        $groups = $this->groupRepository->findAll($user_id);

        $all_contacts =  $this->contactRepository->findAll($user_id);

        return [
            'contacts' => $contacts,
            'groups' => $groups,
            'all_contacts' => $all_contacts
        ];
    }

    public function show($id){
        $user_id = Auth::user()->id;

        $groups = $this->groupRepository->findAll($user_id);

        $provinces_ibge = file_get_contents('http://www.geonames.org/childrenJSON?geonameId=3469034');
        $provinces = array_map(function ($province) {
            return $province->adminCodes1->ISO3166_2;
        }, json_decode($provinces_ibge)->geonames);

        if ($id) {
            $contact = $this->contactRepository->findById($id, $user_id);

            if (!$contact)
                return response("Contato não encontrado", 404);

            $contact_groups = $this->contactGroupRepository->findAll($contact->id);
            $phones = $this->phoneRepository->findAll($contact->id);
            $addresses = $this->addressRepository->findAll($contact->id);

            return [
                "groups" => $groups,
                "contact" => [
                    "data" => $contact,
                    "contact_groups" => $contact_groups,
                    "phones" => $phones,
                    "addresses" => $addresses,
                ],
                "provinces" => $provinces
            ];
        }

        return [
            "groups" => $groups,
            "contact" => [
                "data" => [],
                "contact_groups" => [],
                "phones" => [],
                "addresses" => [],
            ],
            "provinces" => $provinces
        ];
    }

    public function store($name, $name_file, $groups, $phones, $addresses){
        $user_id = Auth::user()->id;

        $contact = $this->contactRepository->store($user_id, $name, $name_file);

        foreach ($addresses as $address) {
            $this->addressRepository->store($address, $contact->id);
        }

        foreach ($phones as $name) {
            $this->phoneRepository->store($name, $contact->id);
        }

        foreach ($groups as $group_id) {
            $this->contactGroupRepository->store($user_id, $group_id, $contact->id);
        }

        return $contact;
    }

    public function update($id, $name, $name_file, $groups, $phones, $addresses){
        $user_id = Auth::user()->id;

        $contact = $this->contactRepository->findById($id, $user_id);

        if (!$contact)
            return response("Contato não encontrado", 404);
            
        $contact = $this->contactRepository->update($contact, $name, $name_file);

        $this->addressRepository->deleteByContactId($contact->id);

        foreach ($addresses as $address) {
            $this->addressRepository->store($address, $contact->id);
        }

        $this->phoneRepository->deleteByContactId($contact->id);

        foreach ($phones as $name) {
            $this->phoneRepository->store($name, $contact->id);
        }

        $this->contactGroupRepository->deleteByContactId($contact->id);

        foreach ($groups as $group_id) {
            $this->contactGroupRepository->store($user_id, $group_id, $contact->id);
        }

        return $contact;
    }

    public function destroy(int $id){
        $user_id = Auth::user()->id;

        $contact = $this->contactRepository->findById($id, $user_id);

        if (!$contact)
            return response("Contato não encontrado", 404);

        $this->addressRepository->deleteByContactId($contact->id);
        $this->phoneRepository->deleteByContactId($contact->id);
        $this->contactGroupRepository->deleteByContactId($contact->id);

        $this->contactRepository->delete($contact);
    }
}
