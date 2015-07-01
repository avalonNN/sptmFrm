<?php

namespace sptmFrm\exception;

/**
 * Description of AppException
 *
 * @author aciden
 */
class AppException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        return $this->getMess();
    }

    public function getMess()
    {
        echo '<p><b>Error:</b> '.$this->getMessage();
    }
}