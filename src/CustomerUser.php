<?php declare(strict_types=1);

namespace App;

use App\Interfaces\Resettable;
use App\Traits\CanLogin;


class CustomerUser extends UserBase implements Resettable
{
    use CanLogin;

    private int $loyaltyPoints = 0;
    // Numeric array: list of purchase amounts (order matters for history).
    private array $purchaseHistory = [];

    public function __construct(string $name, string $email)
    {
        parent::__construct($name, $email, self::ROLE_CUSTOMER);
    }

    public function resetPassword(): string
    {
        return 'customer-temp';
    }

    public function addPurchase(float $amount): void
    {
        $this->purchaseHistory[] = $amount;
        $this->loyaltyPoints += (int) floor($amount);
    }

    public function getTotalSpent(): float
    {
        return array_sum($this->purchaseHistory);
    }

    public function getLoyaltyPoints(): int
    {
        return $this->loyaltyPoints;
    }
}