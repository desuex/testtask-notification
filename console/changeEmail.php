<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Desuex\TesttaskNotification\UserEmailChangerService;
use Desuex\TesttaskNotification\UserEmailSender;

// Get command line arguments
$userId = (int) $argv[1];
$newEmail = $argv[2];

// Create an instance of PDO and other necessary classes
$db = new \PDO('mysql:host=localhost;dbname=testdb', 'username', 'password');
$emailSender = new UserEmailSender();

// Create an instance of UserEmailChangerService
$emailChanger = new UserEmailChangerService($db, $emailSender);

// Call the changeEmail method
$emailChanger->changeEmail($userId, $newEmail);

echo "Email has been changed successfully." . PHP_EOL;
