<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 21.10.2017
 * Time: 21:23
 */

namespace Api\Exceptions;

use Exception;

class RequestTeamSpeakInstanseIsNotAllow extends Exception {
	public function __construct( $message = "Запрашиваемая привелегия не разрешена" ) {
	}

}