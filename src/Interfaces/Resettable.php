<?php declare(strict_types=1);

namespace App\Interfaces;

interface Resettable
{
    /**
     * Reset the users password and return the new temporary value.
     *
     * @return string
     */
    public function resetPassword(): string;
    
}