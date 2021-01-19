<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\ContactServiceInterface;
use App\Repositories\PhoneRepositoryInterface;
use App\Repositories\GroupRepositoryInterface;
use App\Repositories\ContactRepositoryInterface;
use App\Repositories\AddressRepositoryInterface;
use App\Repositories\ContactGroupRepositoryInterface;

class ContactService implements ContactServiceInterface
{
    /**
     * Cria uma nova intância do service e faz injeção de dependência dos services
     *
     * @param App\Repositories\ContactRepositoryInterface $contactService
     * @param App\Repositories\AddressRepositoryInterface $addressRepository
     * @param App\Repositories\ContactGroupRepositoryInterface $contactGroupRepository
     * @param App\Repositories\PhoneRepositoryInterface $phoneRepository
     * @param App\Repositories\GroupRepositoryInterface $groupRepository
     * @return void
     */

    public function __construct(
        ContactRepositoryInterface $contactRepository,
        AddressRepositoryInterface $addressRepository,
        ContactGroupRepositoryInterface $contactGroupRepository,
        PhoneRepositoryInterface $phoneRepository,
        GroupRepositoryInterface $groupRepository
    ) {
        $this->contactRepository = $contactRepository;
        $this->addressRepository = $addressRepository;
        $this->contactGroupRepository = $contactGroupRepository;
        $this->phoneRepository = $phoneRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Método de listar contatos.
     *
     * @param int $group_id
     * @param string $search
     * @param int $per_page
     * @return array
     */

    public function index($group_id, $search, $per_page = 10)
    {
        $user_id = Auth::user()->id;

        $contacts = $this->contactRepository->findAllPaginate($user_id, $group_id, $search, $per_page);

        $groups = $this->groupRepository->findAll($user_id);

        $all_contacts =  $this->contactRepository->findAll($user_id);

        return [
            'contacts' => $contacts,
            'groups' => $groups,
            'all_contacts' => $all_contacts
        ];
    }

    /**
     * Método de buscar contato
     *
     * @param int $id
     * @return array
     */

    public function show($id)
    {
        $user_id = Auth::user()->id;

        $groups = $this->groupRepository->findAll($user_id);

        $provinces_ibge = file_get_contents('http://www.geonames.org/childrenJSON?geonameId=3469034');
        $provinces = array_map(function ($province) {
            return $province->adminCodes1->ISO3166_2;
        }, json_decode($provinces_ibge)->geonames);

        if ($id) {
            $contact = $this->contactRepository->findById($id, $user_id);

            if (!$contact) {
                return response("Contato não encontrado", 404);
            }

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

    /**
     * Método de cadastrar contato
     *
     * @param string $name
     * @param string $name_file
     * @param array $groups
     * @param array $phones
     * @param array $addresses
     * @return object
     */

    public function store($name, $name_file, $groups, $phones, $addresses)
    {
        $user_id = Auth::user()->id;

        $contact = $this->contactRepository->store($user_id, $name, $name_file);

        if ($addresses && sizeof($addresses)) {
            foreach ($addresses as $address) {
                $this->addressRepository->store($address, $contact->id);
            }
        }

        if ($phones && sizeof($phones)) {
            foreach ($phones as $name) {
                $this->phoneRepository->store($name, $contact->id);
            }
        }

        if ($groups && sizeof($groups)) {
            foreach ($groups as $group_id) {
                $this->contactGroupRepository->store($user_id, $group_id, $contact->id);
            }
        }

        return $contact;
    }

    /**
     * Método de alterar contato
     *
     * @param int $id
     * @param string $name
     * @param string $name_file
     * @param array $groups
     * @param array $phones
     * @param array $addresses
     * @return object
     */

    public function update($id, $name, $name_file, $groups, $phones, $addresses)
    {
        $user_id = Auth::user()->id;

        $contact = $this->contactRepository->findById($id, $user_id);

        if (!$contact) {
            return response("Contato não encontrado", 404);
        }

        $contact = $this->contactRepository->update($contact, $name, $name_file);

        $this->addressRepository->deleteByContactId($contact->id);

        if ($addresses && sizeof($addresses)) {
            foreach ($addresses as $address) {
                $this->addressRepository->store($address, $contact->id);
            }
        }

        $this->phoneRepository->deleteByContactId($contact->id);

        if ($phones && sizeof($phones)) {
            foreach ($phones as $name) {
                $this->phoneRepository->store($name, $contact->id);
            }
        }

        $this->contactGroupRepository->deleteByContactId($contact->id);

        if ($groups && sizeof($groups)) {
            foreach ($groups as $group_id) {
                $this->contactGroupRepository->store($user_id, $group_id, $contact->id);
            }
        }

        return $contact;
    }

    /**
     * Método de deletar contato.
     *
     * @param int $id
     * @return void
     */

    public function destroy(int $id)
    {
        $user_id = Auth::user()->id;

        $contact = $this->contactRepository->findById($id, $user_id);

        if (!$contact) {
            return response("Contato não encontrado", 404);
        }

        $this->addressRepository->deleteByContactId($contact->id);
        $this->phoneRepository->deleteByContactId($contact->id);
        $this->contactGroupRepository->deleteByContactId($contact->id);

        $this->contactRepository->delete($contact);
    }
}
