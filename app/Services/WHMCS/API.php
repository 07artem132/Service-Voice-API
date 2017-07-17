<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 26.06.2017
 * Time: 16:12
 */

namespace Api\Services\WHMCS;

use Api\Exceptions\BillingValidateLoginException;
use GuzzleHttp\Client as HTTPClient;

class API
{
    private $identifier = '';
    private $secret = '';
    private $APIURL = '';

    function __construct()
    {

        $this->identifier = env('BILLING_ID');
        $this->secret = env('BILLING_SECRET');
        $this->APIURL = env('BILLING_API_URL');
    }

    function ValidateCredentials($credentials)
    {
        $client = new HTTPClient();

        $response = $client->request('POST', $this->APIURL, [
            'form_params' => [
                'identifier' => $this->identifier,
                'secret' => $this->secret,
                'action' => 'ValidateLogin',
                'email' => $credentials['email'],
                'password2' => $credentials['password'],
                'responsetype' => 'json',

            ]
        ]);

        $response = json_decode($response->getBody());

        if ($response->result != 'success') {
            throw new  BillingValidateLoginException($response->message);
        }

        return $response;
    }
}