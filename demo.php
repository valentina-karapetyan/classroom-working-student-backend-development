<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\AdminUser;
use App\CustomerUser;
use App\UserBase;
use InvalidArgumentException;

echo "PHP Basics Coding Challenge Demo\n\n";

// Regular function to format user information
function formatUser(UserBase $user): string
{
	return $user->getName() . ' <' . $user->getEmail() . '> [' . $user->role . ']';
}

// Create user instances
$admin = new AdminUser('Alice', 'alice@example.com', ['manage_users', 'view_reports']);
$customer = new CustomerUser('Ben', 'ben@example.com');

// Associative array: user profile with labeled keys
// Useful when we need named access to related data (e.g., name, email, role)
$adminProfile = [
	'name' => $admin->getName(),
	'email' => $admin->getEmail(),
	'role' => $admin->role,
	'permissions_count' => count($admin->getPermissions()),
];

echo "Admin Profile (associative array):\n";
foreach ($adminProfile as $key => $value) {
	echo "  $key: $value\n";
}
echo "\n";

// Numeric array: list of purchase amounts
// Useful for ordered data where position/sequence matters (e.g., history, totals)
$purchases = [19.99, 42.50, 5.00, 15.75];

foreach ($purchases as $amount) {
	$customer->addPurchase($amount);
}

// Use array_filter to find big purchases (closure example)
$bigPurchases = array_filter(
	$purchases,
	fn (float $amount): bool => $amount > 20
);

// Use array_map to format amounts as currency strings (closure example)
$formatted = array_map(
	fn (float $amount): string => '$' . number_format($amount, 2),
	$bigPurchases
);

echo "Purchase History (numeric array):\n";
echo "  All purchases: " . implode(', ', array_map(fn ($a) => '$' . number_format($a, 2), $purchases)) . "\n";
echo "  Big purchases (>$20): " . implode(', ', $formatted) . "\n";
echo "  Total spent: $" . number_format($customer->getTotalSpent(), 2) . "\n";
echo "  Loyalty points earned: " . $customer->getLoyaltyPoints() . "\n\n";

// Conditional check with if/else
if ($customer->getTotalSpent() > 50) {
	echo "  → Customer is a premium spender!\n";
} else {
	echo "  → Customer has moderate spending.\n";
}
echo "\n";

// Switch statement to check user role
echo "Role check (switch):\n";
switch ($admin->role) {
	case UserBase::ROLE_ADMIN:
		echo "  Admin user detected with all privileges\n";
		break;
	case UserBase::ROLE_CUSTOMER:
		echo "  Customer user detected with limited access\n";
		break;
	default:
		echo "  Unknown role\n";
}
echo "\n";

// While loop to iterate through admin permissions
echo "Admin Permissions (while loop):\n";
$permissions = $admin->getPermissions();
$index = 0;
while ($index < count($permissions)) {
	echo "  - " . $permissions[$index] . "\n";
	$index++;
}
echo "\n";

// Test CanLogin trait
$admin->login('secret123');
echo "Login State (trait usage):\n";
echo "  Admin isLoggedIn: " . ($admin->isLoggedIn() ? 'yes' : 'no') . "\n";
$admin->logout();
echo "  After logout: " . ($admin->isLoggedIn() ? 'yes' : 'no') . "\n\n";

// Simulate $_POST data and use magic __set
$_POST['email'] = $_POST['email'] ?? 'newemail@example.com';
$customer->email = $_POST['email'];

// Exception handling: email validation
echo "Exception Handling (try/catch):\n";
try {
	new CustomerUser('Invalid User', 'not-a-valid-email');
} catch (InvalidArgumentException $exception) {
	echo "  Caught: " . $exception->getMessage() . "\n";
}
echo "\n";

// Output formatted users
echo "Formatted Output:\n";
echo "  " . formatUser($admin) . "\n";
echo "  " . formatUser($customer) . "\n\n";

// Unit tests with asserts
echo "Assertions:\n";
assert($admin instanceof UserBase, 'AdminUser should be instance of UserBase');
assert($customer instanceof UserBase, 'CustomerUser should be instance of UserBase');
assert(UserBase::getInstanceCount() === 2, 'Should have exactly 2 user instances');
assert($customer->getTotalSpent() === 83.24, 'Total spent should match purchases');
assert(count($admin->getPermissions()) === 2, 'Admin should have 2 initial permissions');
echo "  All assertions passed!\n";