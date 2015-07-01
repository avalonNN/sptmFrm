<?php
namespace sptmFrm\exception;

use sptmFrm\log\Log;

/**
 * Description of ControllerException
 *
 * @author aciden
 */
class ControllerException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        return $this->getMess();
    }

    public function getMess()
    {
        echo '<p><b>Error:</b> '.$this->getMessage();
        Log::record('error', $this->getMessage());
    }
}
