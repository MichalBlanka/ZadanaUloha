<?php
use PHPUnit\Framework\TestCase;
use MyClient\WhaleBooksClient\BooksClient;

class BooksClientTest extends TestCase
{
    public function testGetBooks()
    {
        $client = new BooksClient('test-api-key');
        $response = $client->getBooks();

        $this->assertIsArray($response);
    }

    public function testGetBookById()
    {
        $client = new BooksClient('test-api-key');
        $response = $client->getBookById(1);

        $this->assertIsArray($response);
    }

    public function testInvalidId()
    {
        $client = new BooksClient('test-api-key');
        $response = $client->getBookById('invalid');

        $this->assertArrayHasKey('error', $response);
        $this->assertTrue($response['error']);
    }
}

