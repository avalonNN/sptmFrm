<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace icc\log;

use icc\log\LogManager;
use icc\log\LogRecord;

/**
 * Description of Log
 *
 * @author aciden
 */
class Log extends LogManager
{
    private $_level = 'error';
    private $_output = 'log.txt';
    private $_type = 'file';




    static $record = [];

    public function __construct($type = null, $level = null, $output = null)
    {
        $this->_level = !empty($level) ? $level : $this->_level;
        $this->_output = !empty($output) ? $output : $this->_output;
        $this->_type = !empty($type) ? $type : $this->_type;
    }

    public function make()
    {
        return null;
    }

    public static function record($type, $msg)
    {
        self::$record[][$type] = date('r') . ' [' . (count(self::$record) + 1) . '] - [' . $type . '] - ' . $msg;
    }

    public function __destruct()
    {
        switch ($this->_type) {

            case 'display':
                echo $this->getLog();
                break;

            case 'mail':

                break;

            case 'file':

                break;

            default :

                null;
        }
    }

    public function getLog()
    {
        $msg = '<hr /><table width="100%" style="position:absolute"><tbody>Журналирование работы фрэймворка</tbody>';

        foreach (self::$record as $line) {
            foreach ($line as $val) {
                $msg .= (sprintf('<tr><td>%s</td></tr>', $val));
            }
        }

        $msg .= '<tr><td height="30px"></td></tr></table>';

        return $msg;
    }
}
