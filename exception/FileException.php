<?php
namespace icc\exception;

/**
 * Description of FileException
 *
 * @author aciden
 */
class FileException extends \Exception
{
    
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        return $this->getMess();
    }
    
    public function getMess()
    {
        echo '<p><b>Error:</b> '.$this->getMessage().'<br />'.
            '<b>In file:</b> '.$this->getFile().
            ' - <b>line:</b> '.$this->getLine().'</p>';
    }
}
