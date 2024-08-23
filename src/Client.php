<?php

namespace Thevenrex\MailTm;

use CurlHandle;

class Client
{

    protected CurlHandle $ch;

    protected $result;

    protected $default_options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
    ];

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch, $this->default_options);
    }

    public static function create()
    {
        return (new self);
    }

    public function GET($url)
    {
        $this->setOpt(
            [
                CURLOPT_URL => $url,
                CURLOPT_POST => false,
                CURLOPT_CUSTOMREQUEST => 'GET'
            ]
        );
        return $this;
    }

    public function POST($url, $data)
    {
        $this->setOpt(
            [
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data
            ]
        );
        return $this;
    }

    public function setOpt($options)
    {
        curl_setopt_array($this->ch, $options);
        return $this;
    }

    public function __call($name, $arguments)
    {
        $url = \array_shift($arguments);

        print_r($arguments);

        return $this->create()->setOpt([
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $name,
            CURLOPT_POSTFIELDS => json_encode($arguments[0]),
            CURLOPT_HTTPHEADER => $arguments[1] ?? []
        ]);
    }

    public function run()
    {
        $this->result = curl_exec($this->ch);
        return $this;
    }

    public function getResult(bool $decode = false)
    {
        return $decode ? json_decode($this->result, true) : $this->result;
    }
}