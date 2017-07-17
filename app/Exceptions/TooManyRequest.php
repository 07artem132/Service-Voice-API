<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 06.07.2017
 * Time: 22:11
 */

namespace Api\Exceptions;

use Exception;


class TooManyRequest extends Exception
{
    public $retryAfter;

    public function __construct($retryAfter)
    {
        $this->retryAfter = $retryAfter;
    }
}