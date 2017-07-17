<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.06.2017
 * Time: 16:40
 */

namespace Api\Services\TeamSpeak3;

use GuzzleHttp\Client as HTTPClient;

class Update
{
    private $versionServer;

    function __construct()
    {
        $client = new HTTPClient();

        $response = $client->request('GET', env('UPDATE_SERVER_URL'));

        $this->versionServer = json_decode($response->getBody());
    }

    public function GetUpdateServerMirrorList()
    {
        return $this->versionServer;
    }

    public function GetLastVersionUpdateServer($os, $platform = 'x86_64')
    {
        $os = mb_strtolower($os);
        $platform = mb_strtolower($platform);

        return $this->versionServer->$os->$platform->version;
    }

    public function OutdatedCheck($CurrentVersion, $os, $platform = 'x86_64')
    {
        if ($this->GetLastVersionUpdateServer($os, $platform) === $CurrentVersion) {
            return $data = [
                'outdated' => false,
                'ServerVersion' => $CurrentVersion,
                'VersionUpdateServer' => $this->GetLastVersionUpdateServer($os, $platform)
            ];
        }
        return $data = [
            'outdated' => true,
            'ServerVersion' => $CurrentVersion,
            'VersionUpdateServer' => $this->GetLastVersionUpdateServer($os, $platform)
        ];
    }

}