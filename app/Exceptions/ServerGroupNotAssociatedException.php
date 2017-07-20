<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 16:12
 */

namespace Api\Exceptions;

use Exception;

/**
 * Class ServerGroupNotFaundException
 * @package Api\Exceptions
 */
class ServerGroupNotAssociatedException extends Exception
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
     * ServerGroupNotFaundException constructor.
     * @param int $server_id
     * @param string $group
     */
    public function __construct(int $server_id, string $group)
    {
        $this->server_id = $server_id;
        $this->group = $group;

        parent::__construct();
    }


}
