<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 15:42
 */

namespace Api\Exceptions;

use Exception;

/**
 * Сервер уже принадлежит группе
 * Class ServerGroupExistException
 * @package Api\Exceptions
 */
class ServerGroupExistException extends Exception
{
    /**
     * @var int
     */
    public $server_id;
    /**
     * @var string
     */
    public $group;


    /**
     * ServerGroupExistException constructor.
     * @param int $server_id
     * @param int $group
     */
    public function __construct(int $server_id, string $group)
    {
        $this->server_id = $server_id;
        $this->group = $group;

        parent::__construct();
    }


}

