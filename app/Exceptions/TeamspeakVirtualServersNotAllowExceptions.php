<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.07.2017
 * Time: 13:08
 */

namespace Api\Exceptions;

use Exception;

class TeamspeakVirtualServersNotAllowExceptions extends Exception
{
    private $server_id;
    private $uid;

    function __construct($server_id, $uid)
    {
        $this->server_id = $server_id;
        $this->uid = $uid;
    }
}