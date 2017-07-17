<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 11.07.2017
 * Time: 22:11
 */

namespace Api\Services\Domain;

use GuzzleHttp\Client as HTTPClient;

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
     * @param string $key
     * @param mixed $value
     */
    private function AddRequestOption(string $key, $value)
    {
        $this->request_option[$key] = $value;

        return;
    }

    /**
     * @param string $domain
     * @param mixed $json
     * @return mixed
     */
    public function DomainRecordCreate(string $domain, mixed $json): mixed
    {
        $this->AddRequestOption('body', $this->BildJsonRecordCreateOrEdit($domain, $json));

        $Response = $this->SendHttpRequest('PATCH', 'servers/' . $this->server_id . '/zones/' . $domain);

        return $Response;
    }

    /**
     * @param string $domain
     * @param mixed $json
     * @return mixed
     */
    public function DomainRecordDelete(string $domain, mixed $json): mixed
    {
        $this->AddRequestOption('body', $this->BildJsonRecordDelete($domain, $json));

        $Response = $this->SendHttpRequest('PATCH', 'servers/' . $this->server_id . '/zones/' . $domain);

        return $Response;
    }

    /**
     * @param string $domain
     * @param $json
     * @return string
     */
    function BildJsonRecordCreateOrEdit(string $domain, $json)
    {
        for ($i = 0; $i < count($json); $i++) {
            $array['rrsets'][$i]['name'] = $json[$i]['name'] . '.' . $domain . '.';
            $array['rrsets'][$i]['type'] = $json[$i]['type'];
            $array['rrsets'][$i]['ttl'] = $json[$i]['ttl'];
            $array['rrsets'][$i]['changetype'] = 'REPLACE';
            for ($j = 0; $j < count($json[$i]['records']); $j++) {
                $array['rrsets'][$i]['records'][$j]['content'] = $json[$i]['records'][$j]['content'];
                $array['rrsets'][$i]['records'][$j]['disabled'] = $json[$i]['records'][$j]['disabled'];
            }
        }

        return json_encode($array);
    }

    /**
     * @param string $domain
     * @param string $json
     * @return string
     */
    function BildJsonRecordDelete(string $domain, $json)
    {
        for ($i = 0; $i < count($json); $i++) {
            $array['rrsets'][$i]['name'] = $json[$i]['name'] . '.' . $domain . '.';
            $array['rrsets'][$i]['type'] = $json[$i]['type'];
            $array['rrsets'][$i]['ttl'] = $json[$i]['ttl'];
            $array['rrsets'][$i]['changetype'] = 'DELETE';
            for ($j = 0; $j < count($json[$i]['records']); $j++) {
                $array['rrsets'][$i]['records'][$j]['content'] = $json[$i]['records'][$j]['content'];
                $array['rrsets'][$i]['records'][$j]['disabled'] = $json[$i]['records'][$j]['disabled'];
            }
        }

        return json_encode($array);
    }

    /**
     * @param  $json
     * @return mixed
     */
    function BildJsonDomainCreate($json)
    {
        $array['name'] = $json['domain'];
        $array['kind'] = $json['kind'];
        $array['nameservers'] = $json['nameservers'];

        return json_encode($array);
    }

    /**
     * @param $json
     * @return mixed
     */
    public function DomainCreate($json)
    {
        $this->AddRequestOption('body', $this->BildJsonDomainCreate($json));

        $Response = $this->SendHttpRequest('POST', 'servers/' . $this->server_id . '/zones');

        return $Response;
    }

    /**
     * @param string $domain
     * @return array
     */
    public function DomainRecordList(string $domain)
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
    public function DomainRecordFormatedList(string $domain)
    {
        $Response = $this->SendHttpRequest('GET', 'servers/' . $this->server_id . '/zones/' . $domain);

        for ($i = 0; $i < count($Response->rrsets); $i++) {
            $DomainRecordList[$Response->rrsets[$i]->type][] = [
                'name' => $Response->rrsets[$i]->name,
                'records' => $this->RecordsContentFormated($Response->rrsets[$i]->type, $Response->rrsets[$i]->records),
                'ttl' => $Response->rrsets[$i]->ttl,
                'comments' => $Response->rrsets[$i]->comments,
            ];
        }

        return $DomainRecordList;
    }

    /**
     * @param string $Type
     * @param string $Records
     * @return mixed
     */
    private function RecordsContentFormated(string $Type, string $Records)
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
    public function DomainList()
    {
        $Response = $this->SendHttpRequest('GET', 'servers/' . $this->server_id . '/zones');

        for ($i = 0; $i < count($Response); $i++) {
            $domain[] = substr($Response[$i]->name, 0, -1);
        }

        return $domain;
    }

    /**
     * @param string $Method
     * @param string $Url
     * @return mixed
     */
    private function SendHttpRequest(string $Method, string $Url)
    {
        $res = $this->pdns_client->request($Method, $Url, $this->request_option);

        if ($res->getStatusCode() === 200)
            return json_decode($res->getBody());

        return null;
    }

}