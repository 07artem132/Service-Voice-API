<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 21.10.2017
 * Time: 21:21
 */

namespace Api\Exceptions;

use Exception;

class RequestPrivilegesIsNotAllow extends Exception{
	public function __construct( $message = "Запрашиваемая привелегия не разрешена" ) {
	}

}