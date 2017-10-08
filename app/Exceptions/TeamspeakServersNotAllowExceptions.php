<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 31.07.2017
 * Time: 12:46
 */

namespace Api\Exceptions;

use Exception;

class TeamspeakServersNotAllowExceptions extends Exception
{
    private $server_id;

    function __construct($server_id)
    {
        $this->server_id = $server_id;
    }

}