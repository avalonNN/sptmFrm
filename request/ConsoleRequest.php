<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace icc\request;

/**
 * Description of consoleRequest
 *
 * @author aciden
 */
class ConsoleRequest extends CommandRequest
{
    // filter_input(INPUT_SERVER, 'argv')

    public function execute()
    {
        return null;
    }
}