<?php

namespace Sevenpluss\NewsCrud\Exceptions;

use Exception;

/**
 * Class NoContentException
 * @package Sevenpluss\NewsCrud\Exceptions
 */
class NoContentException extends Exception
{
    /**
     * @var string|null
     */
    protected $message;

    /**
     * @var int
     */
    protected $code = 204;

    /**
     * NoContentException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
