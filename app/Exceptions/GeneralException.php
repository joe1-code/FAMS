<?php

namespace App\Exceptions;

use Exception;

/**
 * Class GeneralException
 * @package App\Exceptions
 */
class GeneralException extends Exception {

    public function __construct($message)
    {
        parent::__construct($message);
    }
}