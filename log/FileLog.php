<?php

namespace sptmFrm\log;

use sptmFrm\log\LogRecord;

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