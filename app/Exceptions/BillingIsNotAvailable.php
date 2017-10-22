<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 16.10.2017
 * Time: 22:09
 */

namespace Api\Exceptions;

use Exception;

/**
 * Class BillingIsNotAvailable
 * @package Api\Exceptions
 */
class BillingIsNotAvailable extends Exception {
	/**
	 * BillingIsNotAvailable constructor.
	 *
	 * @param string $message
	 */
	public function __construct( $message ) {
		parent::__construct( $message );
	}
}