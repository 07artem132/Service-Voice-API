<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 21.10.2017
 * Time: 21:16
 */

namespace Api\Exceptions;

use Exception;


class UserAlreadyRegistered extends Exception {
	public function __construct( $message = "User already registered" ) {
	}
}