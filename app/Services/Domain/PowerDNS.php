<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 11.07.2017
 * Time: 22:11
 */

namespace Api\Services\Domain;

use GuzzleHttp\Client as HTTPClient;
use GuzzleHttp\Exception\RequestException;
use Api\Exceptions\PowerDnsClientException;
use Api\Exceptions\DomainEditNotMatchDomainFromUrlException;

/**
 * Class PowerDNS
 * @package Api\Services\Domain
 */
class PowerDNS
{
    private $url;
    private $key;
    private $server_id;
    private $pdns_client;
    private $request_option = [];

    function __construct()
    {
        $this->url = env('POWER_DNS_URL');
        $this->key = env('POWER_DNS_X-API-KEY');
        $this->server_id = env('POWER_DNS_SERVER_ID', 'localhost');

        $this->pdns_client = new HTTPClient([
            // Base URI is used with relative requests
            'base_uri' => $this->url,
            // You can set any number of default request options.
            'timeout' => 2.0,

            'headers' => ['X-API-Key' => $this->key]
        ]);
    }

    /**
     * Удалить домен
     * @param string $domain домен
     */
    public function DomainDelete(string $domain): void
    {
        $this->SendHttpRequest('DELETE', 'servers/' . $this->server_id . '/zones/' . $domain);
        return;
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function AddRequestOption(string $key, string $value): void
    {
        $this->request_option[$key] = $value;

        return;
    }

    /**
     * @param string $domain
     * @param mixed $json
     * @return mixed
     */
    public function DomainRecordCreate(string $domain, string $name, string $type, int $ttl, array $records): void
    {
        $this->VerifiEditDomain($domain, $name);

        $this->AddRequestOption('body', $this->BildJsonRecordCreateOrEdit($name, $type, $ttl, $records));

        $this->SendHttpRequest('PATCH', 'servers/' . $this->server_id . '/zones/' . $domain);

        return;
    }

    /**
     * @param string $domain Домен из url
     * @param string $name полная запись которую хотят изменить
     * @throws DomainEditNotMatchDomainFromUrlException
     */
    private function VerifiEditDomain(string $domain, string $name): void
    {
        $re = '/(' . quotemeta($domain) . '\.)$/';

        preg_match($re, $name, $matches, PREG_OFFSET_CAPTURE, 0);

        if (empty($matches))
            throw new DomainEditNotMatchDomainFromUrlException($domain, $name);//TODO здесь должно быть исключение

        return;
    }

    /**
     * @param string $domain
     * @param mixed $json
     * @return mixed
     */
    public function DomainRecordDelete(string $domain, string $name, string $type, int $ttl, array $records): void
    {
        $this->VerifiEditDomain($domain, $name);

        $this->AddRequestOption('body', $this->BildJsonRecordDelete($name, $type, $ttl, $records));

        $this->SendHttpRequest('PATCH', 'servers/' . $this->server_id . '/zones/' . $domain);

        return;
    }

    /**
     * @param string $domain
     * @param $json
     * @return string
     */
    private function BildJsonRecordCreateOrEdit(string $name, string $type, int $ttl, array $records): string
    {
        $array['rrsets'][0]['name'] = $name;
        $array['rrsets'][0]['type'] = $type;
        $array['rrsets'][0]['ttl'] = $ttl;
        $array['rrsets'][0]['changetype'] = 'REPLACE';
        $array['rrsets'][0]['records'] = $records;
        return json_encode($array);
    }

    /**
     * @param string $domain
     * @param string $json
     * @return string
     */
    private function BildJsonRecordDelete(string $name, string $type, int $ttl, array $records): string
    {
        $array['rrsets'][0]['name'] = $name;
        $array['rrsets'][0]['type'] = $type;
        $array['rrsets'][0]['ttl'] = $ttl;
        $array['rrsets'][0]['changetype'] = 'DELETE';
        $array['rrsets'][0]['records'] = $records;

        return json_encode($array);
    }

    /**
     * @param  $json
     * @return mixed
     */
    private function BildJsonDomainCreate(string $domain, string $kind, array $nameservers): string
    {
        $array['name'] = $domain;
        $array['kind'] = $kind;
        $array['nameservers'] = $nameservers;

        return json_encode($array);
    }

    /**
     * @param $json
     * @return mixed
     */
    public function DomainCreate(string $domain, string $kind, array $nameservers): \stdClass
    {
        $this->AddRequestOption('body', $this->BildJsonDomainCreate($domain, $kind, $nameservers));

        $Response = $this->SendHttpRequest('POST', 'servers/' . $this->server_id . '/zones');

        unset($Response->url);
        unset($Response->account);

        return $Response;
    }

    /**
     * @param string $domain доменное имя
     * @return array Список записей домена
     */
    public function DomainRecordList(string $domain): array
    {
        $Response = $this->SendHttpRequest('GET', 'servers/' . $this->server_id . '/zones/' . $domain);

        for ($i = 0; $i < count($Response->rrsets); $i++) {
            $DomainRecordList[] = [
                'type' => $Response->rrsets[$i]->type,
                'name' => $Response->rrsets[$i]->name,
                'records' => $Response->rrsets[$i]->records,
                'ttl' => $Response->rrsets[$i]->ttl,
                'comments' => $Response->rrsets[$i]->comments,
            ];
        }

        return $DomainRecordList;

    }

    /**
     * @param string $domain
     * @return array
     */
    public function DomainRecordFormatedList(string $domain): array
    {
        $Response = $this->SendHttpRequest('GET', 'servers/' . $this->server_id . '/zones/' . $domain);

        for ($i = 0; $i < count($Response->rrsets); $i++) {
            $DomainRecordList[$Response->rrsets[$i]->type][] = [
                'name' => $Response->rrsets[$i]->name,
                'records' => $this->RecordsContentFormated((string)$Response->rrsets[$i]->type, (array)$Response->rrsets[$i]->records),
                'ttl' => $Response->rrsets[$i]->ttl,
                'comments' => $Response->rrsets[$i]->comments,
            ];
        }

        return $DomainRecordList;
    }

    /**
     * @param string $Type Тип записи
     * @param array $Records Содержимое записи
     * @return array
     */
    private function RecordsContentFormated(string $Type, array $Records): array
    {
        switch ($Type) {
            case 'SRV';
                for ($i = 0; $i < count($Records); $i++) {
                    $result = explode(" ", $Records[$i]->content);
                    $formated[$i]['Priority'] = $result[0];
                    $formated[$i]['Weight'] = $result[1];
                    $formated[$i]['Port'] = $result[2];
                    $formated[$i]['Target'] = $result[3];
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'A';
                for ($i = 0; $i < count($Records); $i++) {
                    $formated[$i]['ipv4'] = $Records[$i]->content;
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'AAAA';
                for ($i = 0; $i < count($Records); $i++) {
                    $formated[$i]['ipv6'] = $Records[$i]->content;
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'CNAME';
                for ($i = 0; $i < count($Records); $i++) {
                    $formated[$i]['CanonicalName'] = $Records[$i]->content;
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'NS';
                for ($i = 0; $i < count($Records); $i++) {
                    $formated[$i]['NameServer'] = $Records[$i]->content;
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'MX';
                for ($i = 0; $i < count($Records); $i++) {
                    $result = explode(" ", $Records[$i]->content);
                    $formated[$i]['Priority'] = $result[0];
                    $formated[$i]['MailRelay'] = $result[1];
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'PTR';
                for ($i = 0; $i < count($Records); $i++) {
                    $formated[$i]['HostName'] = $Records[$i]->content;
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;
            case 'TXT';
                for ($i = 0; $i < count($Records); $i++) {
                    $formated[$i]['Text'] = $Records[$i]->content;
                    $formated[$i]['disabled'] = $Records[$i]->disabled;
                }
                break;

            default;
                $formated = $Records;
        }

        return $formated;
    }

    /**
     * @return array
     */
    public function DomainList(): array
    {
        $Response = $this->SendHttpRequest('GET', 'servers/' . $this->server_id . '/zones');

        for ($i = 0; $i < count($Response); $i++) {
            unset($Response[$i]->url);
            unset($Response[$i]->account);
        }

        return $Response;
    }

    /**
     * @param string $Method Метод запроса
     * @param string $Url URL к которому необходимо выполнить запрос
     * @return \stdClass Декодированный из json'a ответ
     * @throws PowerDnsClientException
     */
    private function SendHttpRequest(string $Method, string $Url)
    {
        try {
            $res = $this->pdns_client->request($Method, $Url, $this->request_option);
        } catch (RequestException $e) {
            throw new PowerDnsClientException($e->getResponse()->getBody(true));
        }

        //TODO возврашает как array так и stdClass Нужно привести к 1 типу возврашаемых данных
        return json_decode($res->getBody(), false);
    }

}