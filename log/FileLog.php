<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace icc\log;

use icc\log\LogRecord;

/**
 * Description of FileLog
 *
 * @author aciden
 */
class FileLog extends LogRecord
{
    protected function record()
    {
        return __METHOD__;
    }
}