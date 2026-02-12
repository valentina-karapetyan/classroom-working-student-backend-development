<?php declare(strict_types=1);

namespace App;

use App\Interfaces\Resettable;
use App\Traits\CanLogin;

class AdminUser extends UserBase implements Resettable
{
    use CanLogin;

    // Numeric array: simple list of permission strings.
    // Use when we need metadata about each permission (e.g., enabled/disabled).
    private array $permissions = [];

    public function __construct(string $name, string $email, array $permissions = [])
    {
        parent::__construct($name, $email, self::ROLE_ADMIN);
        $this->permissions = $permissions;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function resetPassword(): string
    {
        return 'admin-temp';
    }
}