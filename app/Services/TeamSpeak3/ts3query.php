<?php

/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 27.06.2017
 * Time: 17:40
 */

namespace Api\Services\TeamSpeak3;

use Api\Exceptions\InstanceConfigNotFoundException;
use Api\Exceptions\TeamSpeakInvalidUidException;
use Illuminate\Support\Facades\Log;
use Api\Servers;
use TeamSpeak3;
use TeamSpeak3_Helper_Convert;
use Storage;

class ts3query
{
    private $connection;
    private $InstanceConfig;

    function __construct($InstanceID, $server_id = null)
    {
        $this->InstanceConfig = $this->GetInstanceConfig($InstanceID);

        $Options = 'timeout=' . config('TeamSpeak.connection.timeout');
        $Options .= '&blocking=' . config('TeamSpeak.connection.blocking');
        $Options .= '&nickname=' . config('TeamSpeak.connection.nickname');

        $url = "serverquery://{$this->InstanceConfig->username}:{$this->InstanceConfig->password}@{$this->InstanceConfig->ipaddress}:{$this->InstanceConfig->port}/$Options";
        ($server_id != null) ? $url .= '&server_id=' . $server_id . '#' . config('TeamSpeak.connection.flags') : $url .= '#' . config('TeamSpeak.connection.flags');

        Log::debug('TeamSpeak connection url: ' . $url);

        $this->connection = TeamSpeak3::factory($url);
    }

    function serverCreate(array $config)
    {
        $data = $this->connection->serverCreate($config);
        $data['token'] = (string)$data['token'];
        return $data;
    }

    function VirtualServerBanList()
    {
        try {
            $data = $this->connection->banList();
        } catch (\TeamSpeak3_Adapter_ServerQuery_Exception $e) {
            if ($e->getMessage() === 'database empty result set')
                return 'empty';
        }

        return $data;
    }

    function VirtualServerBanListClear()
    {
        return $this->connection->banListClear();
    }

    function VirtualServerBanCreate($json)
    {
        return $this->connection->banCreate($json['rules'], $json['timeseconds'], $json['reason']);
    }

    function VirtualServerBanDelete($banid)
    {
        return $this->connection->banDelete($banid);
    }

    function VirtualServerStop()
    {
        return $this->connection->serverStop($this->connection['virtualserver_id']);
    }

    function VirtualServerStart()
    {
        return $this->connection->serverStart($this->connection['virtualserver_id']);
    }

    function GetVirtualServerID()
    {
        return $this->connection['virtualserver_id'];
    }

    function InstanceStop()
    {
        return $this->connection->serverStopProcess();
    }

    function instanceinfo()
    {
        return $this->connection->execute('instanceinfo')->toArray();
    }

    function hostinfo()
    {
        return $this->connection->execute('hostinfo')->toArray();
    }

    function serverinfo()
    {
        return $this->connection->execute('serverinfo')->toArray();
    }

    function GetVirtualServerLog($last_pos)
    {
        $logs = $this->connection->logView(100, $last_pos, null, 0);

        $data['last_pos'] = $logs[0]['last_pos'];
        $data['file_size'] = $logs[0]['file_size'];

        unset($logs[0]['last_pos']);
        unset($logs[0]['file_size']);

        for ($i = 0; $i < count($logs); $i++) {
            $log = TeamSpeak3_Helper_Convert::logEntry($logs[$i]["l"]);

            $log['msg'] = (string)$log['msg'];
            $log['msg_plain'] = (string)$log['msg_plain'];

            $data['log'][$i] = $log;
        }

        return $data;
    }

    function GetInstanseLog($last_pos)
    {
        $logs = $this->connection->logView(100, $last_pos, null, 1);

        $data['last_pos'] = $logs[0]['last_pos'];
        $data['file_size'] = $logs[0]['file_size'];

        unset($logs[0]['last_pos']);
        unset($logs[0]['file_size']);

        for ($i = 0; $i < count($logs); $i++) {
            $log = TeamSpeak3_Helper_Convert::logEntry($logs[$i]["l"]);

            $log['msg'] = (string)$log['msg'];
            $log['msg_plain'] = (string)$log['msg_plain'];

            $data['log'][$i] = $log;
        }

        return $data;
    }

    function isBlacklisted()
    {
        return TeamSpeak3::factory("blacklist")->isBlacklisted('92.63.203.189'); //$this->connection);
    }

    function version()
    {
        $data = $this->connection->execute('version')->toArray();

        $data['version'] = (string)$data[0]['version'];
        $data['build'] = (string)$data[0]['build'];
        $data['platform'] = (string)$data[0]['platform'];

        unset($data[0]);

        return $data;
    }

    function serverlist()
    {
        $data = $this->connection->execute('serverlist -uid')->toAssocArray("virtualserver_id");

        foreach ($data as $item) {
            $data[$item['virtualserver_id']]['virtualserver_status'] = (string)$data[$item['virtualserver_id']]['virtualserver_status'];
            $data[$item['virtualserver_id']]['virtualserver_name'] = (string)$data[$item['virtualserver_id']]['virtualserver_name'];
            $data[$item['virtualserver_id']]['virtualserver_unique_identifier'] = (string)$data[$item['virtualserver_id']]['virtualserver_unique_identifier'];
        }

        return $data;
    }

    function GetAllServersSnapshots()
    {
        $data = [];
        foreach ($this->connection as $VirtualServer) {
            $data[$VirtualServer['virtualserver_id']]['unique_id'] = (string)$VirtualServer['virtualserver_unique_identifier'];
            $data[$VirtualServer['virtualserver_id']]['snapshot'] = (string)$VirtualServer->snapshotCreate();
        }

        return $data;
    }


    function GetAllServerStatisticsInfo()
    {
        $data = [];
        foreach ($this->connection as $VirtualServer) {
            $data[$VirtualServer['virtualserver_id']]['unique_id'] = (string)$VirtualServer['virtualserver_unique_identifier'];
            $data[$VirtualServer['virtualserver_id']]['user_online'] = (integer)$VirtualServer['virtualserver_clientsonline'];
            $data[$VirtualServer['virtualserver_id']]['slot_usage'] = (integer)$VirtualServer['virtualserver_maxclients'];
            $data[$VirtualServer['virtualserver_id']]['avg_ping'] = (string)$VirtualServer['virtualserver_total_ping'];
            $data[$VirtualServer['virtualserver_id']]['avg_packetloss'] = (string)$VirtualServer['virtualserver_total_packetloss_total'];
        }

        return $data;
    }

    function logout()
    {
        $this->connection->logout();
    }

    function GetVirtualServerIconList()
    {
        $data = $this->connection->channelFileList('0', '', '/icons');

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['path'] = (string)$data[$i]['path'];
            $data[$i]['name'] = (string)$data[$i]['name'];
            $data[$i]['src'] = (string)$data[$i]['src'];
        }

        return $data;
    }

    function DeleteFile($name, $cpw = '')
    {
        return $this->connection->channelFileDelete(0, '', $name);
    }

    function iconUpload(string $icon): int
    {
        $crc = crc32($icon);
        $size = strlen($icon);

        $upload = $this->connection->transferInitUpload(rand(0x0000, 0xFFFF), 0, "/icon_" . $crc, $size);
        $transfer = TeamSpeak3::factory("filetransfer://" . (strstr($upload["host"], ":") !== FALSE ? "[" . $upload["host"] . "]" : $upload["host"]) . ":" . $upload["port"]);

        $transfer->upload($upload["ftkey"], $upload["seekpos"], $icon);

        return $crc;
    }

    function GetVirtualServerIconListOnlyId()
    {
        $data = $this->connection->channelFileList('0', '', '/icons');

        for ($i = 0; $i < count($data); $i++) {
            $return[$i]['id'] = substr((string)$data[$i]['name'], 5);
        }

        return $return;
    }

    function DownloadFile($cid, $name, $cpw)
    {
        $download = $this->connection->transferInitDownload(rand(0x0000, 0xFFFF), $cid, $name, $cpw);
        $transfer = TeamSpeak3::factory("filetransfer://" . (strstr($download["host"], ":") !== FALSE ? "[" . $download["host"] . "]" : $download["host"]) . ":" . $download["port"]);;
        return $transfer->download($download["ftkey"], $download["size"]);
    }

    function serverGetByUid($uid)
    {
        try {
            $this->connection = $this->connection->serverGetByUid($uid);
        } catch (\TeamSpeak3_Adapter_ServerQuery_Exception $e) {
            throw new TeamSpeakInvalidUidException();
        }
    }

    function snapshotCreate()
    {
        return (string)$this->connection->snapshotCreate();
    }

    function ReturnConnection()
    {
        return $this->connection;
    }

    /**
     * @param $InstanceID Уникальный ID (порядковый номер) инстанса в API
     * @return mixed
     * @throws InstanceConfigNotFoundException
     */
    function GetInstanceConfig($InstanceID)
    {
        $config = Servers::where('id', '=', $InstanceID)->first();
        if (empty($config))
            throw new InstanceConfigNotFoundException($InstanceID);

        return $config;
    }
}