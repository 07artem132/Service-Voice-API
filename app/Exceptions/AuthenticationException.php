<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 27.06.2017
 * Time: 15:31
 */

namespace Api\Exceptions;

use Illuminate\Http\Response;
use Exception;

class AuthenticationException extends Exception
{
    /**
     * All of the guards that were checked.
     *
     * @var array
     */
    protected $guards;

    /**
     * Create a new authentication exception.
     *
     * @param  string $message
     * @param  array $guards
     * @return void
     */
    public function __construct($message = 'Unauthenticated.', array $guards = [])
    {
        parent::__construct($message);

        $this->guards = $guards;

    }

    /**
     * Get the guards that were checked.
     *
     * @return array
     */
    public function guards()
    {
        return $this->guards;
    }
}
