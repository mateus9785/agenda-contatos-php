<?php

namespace App\Http\Services;

use App\Http\Services\RegisterServiceInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Repositories\GroupRepositoryInterface;
use App\Http\Repositories\ContactRepositoryInterface;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        UserRepositoryInterface $userRepository,
        GroupRepositoryInterface $groupRepository,
        ContactRepositoryInterface $contactRepository
    ){
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->contactRepository = $contactRepository;
    }

    public function create($name, $email, $password){
        $user = $this->userRepository->store($email, $password);

        $is_user_contact = true;

        $this->contactRepository->store($user->id, $name, null, $is_user_contact);

        $default_groups = [
            'Favoritos', 'Colegas de trabalho', 'Família', 
            'Amigos', 'Contatos de Emergência'
        ];

        foreach ($default_groups as $group_name) {
            $this->groupRepository->store($user->id, $group_name);
        }

        return $user;
    }
}