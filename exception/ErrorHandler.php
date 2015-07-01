<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace icc\exception;

/**
 * Description of ErrorHandler
 *
 * @author aciden
 */
class ErrorHandler
{

    public function register()
    {
        set_exception_handler([$this, 'handleException']);
    }

    public function handleException($exception)
    {
        //var_dump($exception);
    }
}