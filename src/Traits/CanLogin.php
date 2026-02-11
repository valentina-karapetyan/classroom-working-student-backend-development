<?php declare(strict_types=1);

namespace App\Traits;

trait CanLogin
{
    private bool $loggedIn = false;

    public function login(string $password): bool
    {
        if ($password === '') {
            return false;
        }

        $this->loggedIn = true;
        return true;
    }

    public function logout(): void
    {
        $this->loggedIn = false;
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }
}

