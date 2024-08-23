<?php

namespace Thevenrex\MailTm;


class Mailtm
{

    const string API_URL = 'https://api.mail.tm';

    protected Client $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    public function getDomains(string|int $page = 1)
    {
        return $this->client->GET(self::API_URL . '/domains?page=' . $page)->run();
    }

    public function getDomain(string $domain)
    {
        return $this->client->GET(self::API_URL . '/domains/' . $domain)->setOpt([
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ])->run();
    }

    public function createAccount(string $address, string $password)
    {

        $payload = [
            'address' => $address,
            'password' => $password
        ];

        return $this->client->POST(self::API_URL . '/accounts', json_encode($payload))
            ->setOpt([
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ]
            ])->run();
    }

    public function getTokenAuthorization(string $address, string $password)
    {

        $payload = [
            'address' => $address,
            'password' => $password
        ];

        return $this->client->POST(self::API_URL . '/token', json_encode($payload))
            ->setOpt([
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ]
            ])->run();
    }

    public function getMessages(string $token, int $page = 1) {

        return $this->client->GET(self::API_URL . '/messages?page=' . $page)->setOpt(
            [
                CURLOPT_HTTPAUTH => CURLAUTH_BEARER,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json'
                ]
            ]
        )->run();
    }
}
