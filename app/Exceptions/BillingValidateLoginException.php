<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 27.06.2017
 * Time: 16:10
 */

namespace Api\Exceptions;

use Exception;

class BillingValidateLoginException extends  Exception
{
    /**
     * BillingValidateLoginException constructor.
     * @param string $message
     */
    public function __construct($message = 'Error Validate Login.' )
    {
        parent::__construct($message);

    }


}