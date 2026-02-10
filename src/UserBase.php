<?php declare(strict_types=1);

namespace App;

use InvalidArgumentException;

// Abstract base for all users.
abstract class UserBase
{
	public const ROLE_ADMIN = 'admin';
	public const ROLE_CUSTOMER = 'customer';

	private string $name;
	protected string $email;
	public string $role;

	private static int $instanceCount = 0;

	public function __construct(string $name, string $email, string $role)
	{
		$this->setName($name);
		$this->setEmail($email);
		$this->role = $role;

		self::$instanceCount++;
	}

	public function __toString(): string
	{
		return $this->name . ' <' . $this->email . '> (' . $this->role . ')';
	}

	public function __get(string $property): mixed
	{
		if (property_exists($this, $property)) {
			return $this->$property;
		}

		return null;
	}

	public function __set(string $property, mixed $value): void
	{
		if ($property === 'name') {
			$this->setName((string) $value);
			return;
		}

		if ($property === 'email') {
			$this->setEmail((string) $value);
			return;
		}

		if ($property === 'role') {
			$this->role = (string) $value;
		}
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$trimmed = trim($name);
		if ($trimmed === '') {
			throw new InvalidArgumentException('Name cannot be empty.');
		}

		$this->name = $trimmed;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): void
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException('Invalid email address.');
		}

		$this->email = $email;
	}

	public static function getInstanceCount(): int
	{
		return self::$instanceCount;
	}
}