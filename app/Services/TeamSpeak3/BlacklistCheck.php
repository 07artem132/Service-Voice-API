<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 01.07.2017
 * Time: 0:04
 */

namespace Api\Services\TeamSpeak3;

use Api\Exceptions\Blacklist_Exception;

class BlacklistCheck
{
    private $addres = 'blacklist.teamspeak.com';
    private $port = 17385;
    private $connect;

    public function isBlacklisted($host)
    {
        if (ip2long($host) === FALSE) {
            $addr = gethostbyname($host);

            if ($addr == $host) {
                throw new Blacklist_Exception("Не удалось преобразовать адрес IPv4(" . $host . ")");
            }

            $host = $addr;
        }

        $this->connect();
        $this->SocketWriteIP($host);
        $response = $this->SocketRead();
        $this->SocketClose();
        switch ($response{0}) {
            case 0:
                $code = 0;
                $message = 'Сервер находиться в blacklist списке. (Нельзя подключиться)';
                break;
            case 1:
                $code = 1;
                $message = 'Сервер не находится в blacklist или greylist списке.';
                break;
            case 2:
                $code = 2;
                $message = 'Сервер находиться в greylist списке. (Подключаться можно но будет высплываюшее окошко)';
                break;
        }
        return ['code' => $code, 'message' => $message];
    }

    private function SocketWriteIP($ip)
    {
        fwrite($this->connect, "ip4:" . $ip);
        return;
    }

    private function SocketRead()
    {
        return fread($this->connect, 5);
    }

    private function SocketClose()
    {
        fclose($this->connect);
        return;
    }

    private function connect()
    {
        $fp = stream_socket_client("udp://$this->addres:$this->port", $errno, $errstr);
        if (!$fp) {
            throw new Blacklist_Exception("Ошибка: $errno - $errstr");
        }

        $this->connect = $fp;

        return;
    }
}