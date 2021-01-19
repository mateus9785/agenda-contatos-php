<?php

namespace App\Services;

use App\Services\RegisterServiceInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\GroupRepositoryInterface;
use App\Repositories\ContactRepositoryInterface;

class RegisterService implements RegisterServiceInterface
{
    /**
     * Cria uma nova intância do service e faz injeção de dependência dos services
     *
     * @param App\Repositories\UserRepositoryInterface $contactRepository
     * @param App\Repositories\ContactRepositoryInterface $contactRepository
     * @param App\Repositories\GroupRepositoryInterface $groupRepository
     * @return void
     */

    public function __construct(
        UserRepositoryInterface $userRepository,
        GroupRepositoryInterface $groupRepository,
        ContactRepositoryInterface $contactRepository
    ) {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Método de registrar usuário.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return object
     */

    public function create($name, $email, $password)
    {
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
