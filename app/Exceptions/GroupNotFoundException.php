<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 14:51
 */

namespace Api\Exceptions;

use Exception;

/**
 * Class GroupNotFoundException
 * @package Api\Exceptions
 */
class GroupNotFoundException extends Exception
{
    /**
     * @var
     */
    public $group;

    /**
     * GroupNotFoundException constructor.
     * @param string $group
     */
    public function __construct($group)
    {
        $this->group = $group;
    }

}