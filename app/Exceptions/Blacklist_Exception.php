<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 01.07.2017
 * Time: 0:23
 */

namespace Api\Exceptions;

use Exception;

/**
 * Class Blacklist_Exception
 * @package Api\Exceptions
 */
class Blacklist_Exception extends Exception
{
    /**
     * Blacklist_Exception constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);

    }
}