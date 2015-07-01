<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace icc\request;

/**
 * Description of CommandRequest
 *
 * @author aciden
 */
abstract class CommandRequest
{
    abstract public function execute();
}