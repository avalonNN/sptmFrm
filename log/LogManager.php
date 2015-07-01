<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace sptmFrm\log;

use sptmFrm\log\HandleLog;

/**
 * Description of LogManager
 *
 * @author aciden
 */
abstract class LogManager
{
    const RECORD_FILE = 1;
    const RECORD_MAIL = 2;
    const RECORD_DISPLAY = 3;

    abstract public function make();
}