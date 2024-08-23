<?php

require_once __DIR__ . '/vendor/autoload.php';

use Thevenrex\MailTm\Client;
use Thevenrex\MailTm\Mailtm;
use Thevenrex\MailTm\RandomData;

$mailtm = new Mailtm(
    new Client
);

echo $mailtm->getDomains()->getResult() . "\n";

$domain = $mailtm->getDomain('66b1d17d3ed65a895f447c2e')
    ->getResult(decode: true)['domain'];

$username = RandomData::randomUsername();
$password = RandomData::randomPassword();

$email = $username . '@' . $domain;

echo $mailtm->createAccount($email, $password)
    ->getResult();

echo "Done\n";

echo "Get token\n";
echo "Data: $email, $password\n";

$token = $mailtm->getTokenAuthorization("karryscarlet@rowdydow.com", "5XzB4w)EXB")->getResult(decode: true)['token'] . "\n";

echo "Done\n";

echo "Get Messages\n";

echo $mailtm->getMessages($token)->getResult() . "\n";