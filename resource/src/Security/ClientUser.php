<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class ClientUser implements UserInterface
{
    public function __construct(
        private readonly string $id,
        private readonly array $infos
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return ['ROLE_CLIENT'];
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->id;
    }

    public function infos(): array
    {
        return $this->infos;
    }
}
