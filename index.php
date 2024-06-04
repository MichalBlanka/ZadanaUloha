<?php
require 'vendor/autoload.php';

use MyClient\WhaleBooksClient\BooksClient;

$apiKey = 'your-api-key';
$client = new BooksClient($apiKey);

// Get all books
$books = $client->getBooks();
print_r($books);

// Get a book by ID
$book = $client->getBookById(1);
print_r($book);

// Create a new user
$newUser = $client->createUser([
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'role' => 'admin'
]);
print_r($newUser);

// Get a user by ID
$user = $client->getUserById(1);
print_r($user);

// Update an existing user
$userId = 1;
$updatedUserData = [
    'name' => 'Jane Doe',
    'email' => 'jane.doe@example.com',
    'role' => 'user'
];
$updatedUser = $client->updateUser($userId, $updatedUserData);
print_r($updatedUser);

// Delete a user
$deletedUser = $client->deleteUser(2);
print_r($deletedUser);
?>
