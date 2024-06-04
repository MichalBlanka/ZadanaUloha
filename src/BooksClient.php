<?php

namespace MyClient\WhaleBooksClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Client library for communicating with the WhaleBooks REST API.
 */
class BooksClient
{
    private $client; // Instance GuzzleHttp\Client pro provádění HTTP požadavků.
    private $apiKey; // API klíč pro autentizaci uživatele.

    /**
     * Konstruktor třídy BooksClient.
     *
     * @param string $apiKey API klíč pro autentizaci uživatele.
     * @param string $baseUri (Volitelný) Základní URI pro API, výchozí hodnota je 'https://whalebooks.com/api/'.
     */
    public function __construct($apiKey, $baseUri = 'https://whalebooks.com/api/')
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => rtrim($baseUri, '/') . '/', // Odstranění případných koncových lomítek z baseUri.
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey, // Přidání autentizační hlavičky s API klíčem.
                'Accept' => 'application/json' // Specifikace formátu přijímaných dat.
            ]
        ]);
    }

    /**
     * Metoda pro získání seznamu knih.
     *
     * @return array Pole s informacemi o knihách.
     */
    public function getBooks()
    {
        try {
            $response = $this->client->get('books'); // Vykonání GET požadavku na URL '/books'.
            return json_decode($response->getBody(), true); // Dekódování odpovědi z formátu JSON do pole PHP.
        } catch (RequestException $e) {
            return $this->handleException($e); // Zpracování chyby při komunikaci s API.
        }
    }

    /**
     * Metoda pro získání informací o konkrétní knize podle ID.
     *
     * @param int $id ID knihy.
     * @return array Pole s informacemi o knize.
     */
    public function getBookById($id)
    {
        if (!is_numeric($id)) { // Validace ID knihy.
            return [
                'error' => true,
                'message' => 'Špatně zadané ID'
            ];
        }

        try {
            $response = $this->client->get('books/' . $id); // Vykonání GET požadavku na URL '/books/{id}'.
            return json_decode($response->getBody(), true); // Dekódování odpovědi z formátu JSON do pole PHP.
        } catch (RequestException $e) {
            return $this->handleException($e); // Zpracování chyby při komunikaci s API.
        }
    }

    /**
     * Metoda pro vytvoření nového uživatele.
     *
     * @param array $userData Data nového uživatele.
     * @return array Pole s informacemi o vytvořeném uživateli.
     */
    public function createUser($userData)
    {
        try {
            $response = $this->client->post('organization/users', [
                'json' => $userData
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Metoda pro získání informací o konkrétním uživateli podle ID.
     *
     * @param int $id ID uživatele.
     * @return array Pole s informacemi o uživateli.
     */
    public function getUserById($id)
    {
        try {
            $response = $this->client->get('organization/users/' . $id);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Metoda pro aktualizaci informací o existujícím uživateli.
     *
     * @param int $id ID uživatele.
     * @param array $userData Aktualizovaná data uživatele.
     * @return array Pole s informacemi o aktualizovaném uživateli.
     */
    public function updateUser($id, $userData)
    {
        try {
            $response = $this->client->put('organization/users/' . $id, [
                'json' => $userData
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Metoda pro smazání existujícího uživatele.
     *
     * @param int $id ID uživatele.
     * @return array Pole s informacemi o smazaném uživateli.
     */
    public function deleteUser($id)
    {
        try {
            $response = $this->client->delete('organization/users/' . $id);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Metoda pro zpracování výjimky při komunikaci s API.
     *
     * @param RequestException $e Objekt výjimky.
     * @return array Pole s informacemi o chybě.
     */
    private function handleException(RequestException $e)
    {
        if ($e->hasResponse()) {
            return [
                'error' => true,
                'message' => $e->getResponse()->getBody()->getContents()
            ];
        }

        return [
            'error' => true,
            'message' => $e->getMessage()
        ];
    }
}
