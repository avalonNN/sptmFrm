<?php

namespace icc\base;

use icc\base\Application;

/**
 * Description of UrlManager
 *
 * @author aciden
 */
class UrlManager
{

    /**
     *
     * @var array
     */
    private $_rules = [];


    /**
     * Получает параметры при инициализации из конфигурационного файла
     * .. 'urlManager' => [
     * .. 'rules' => [
     * ..........
     * ..   ]
     * .. ]
     * @param type $rules
     */
    public function __construct($rules = null)
    {
        $this->_rules = $rules;
    }

    /**
     * Обработка запроса если указанны правила
     *
     * @param type $request
     * @return boolean or controller and action
     */
    public function requestRule($request = null)
    {
        if (isset($this->_rules[$request])) {

            $controller = isset($this->_rules[$request]['controller']) ? $this->_rules[$request]['controller'] : null;
            $action = isset($this->_rules[$request]['action']) ? $this->_rules[$request]['action'] : Application::$app->action;
            $params = isset($this->_rules[$request]['params']) ? $this->_rules[$request]['params'] : null;

            return ['controller' => $controller, 'action' => $action, 'params' => $params];
        }
        
        return false;
    }
}
