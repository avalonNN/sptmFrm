<?php
/**
 * Description of Controller
 *
 * @author aciden
 */ 
namespace sptmFrm\base;

use sptmFrm\base\Application;

class Controller
{    
    /**
     * @param string $file render
     * @param array $param variable is render file
     */
    public function render($file = null, $param = array())
    {
        /**
         * if not set file render, get file name action
         */
        if ($file == null) {
            $file = Application::$app->action;
        }
        
        echo Application::$app->view->renderLayout(strtolower($file), $param);
    }
}
