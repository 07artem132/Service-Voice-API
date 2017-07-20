<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 14:21
 */

namespace Api\Exceptions;

use Exception;

/**
 * Class RequestIsNotJson
 * @package Api\Exceptions
 */
class RequestIsNotJson extends Exception
{
    /**
     * RequestIsNotJson constructor.
     */
    public function __construct()
    {
        //
    }

}