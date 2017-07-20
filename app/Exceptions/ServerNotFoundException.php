<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 15:17
 */

namespace Api\Exceptions;

use Exception;

/**
 * Class ServerNotFoundException
 * @package Api\Exceptions
 */
class ServerNotFoundException extends Exception
{
    /**
     * @var string
     */
    public $server_id;

    /**
     * ServerNotFoundException constructor.
     * @param string $server_id
     */
    public function __construct($server_id)
    {
        $this->server_id = $server_id;
    }


}