<?php

namespace icc\route;

use icc\request\Request;
use icc\base\UrlManager;
use icc\base\Application;
use icc\log\Log;
/**
 * Description of Route
 *
 * @author aciden
 */
class Route
{

    /**
     *
     * @var type
     */
    private $_request;

    /**
     *
     * @var type
     */
    private $_rule;

    /**
     *
     * @var type
     */
    private $_rout;
    
    /**
     *
     * @param Request $request
     * @param UrlManager $rule
     */
    public function __construct(Request $request, UrlManager $rule)
    {
        $this->_request = $request;
        $this->_rule = $rule;

        $this->_rout = $this->isIssetRule();

        $this->setController($this->_rout['controller']);
        $this->setAction($this->_rout['action']);

        isset($this->_rout['params']) ? $this->_request->setArrayParams($this->_rout['params']) : null;
    }

    /**
     *
     * @param type $controller
     */
    public function setController($controller = null)
    {
        if ($controller != null) {
            Application::$app->controller = $controller;
        }
    }

    /**
     *
     * @param type $action
     */
    public function setAction($action = null)
    {
        if ($action != null) {
            Application::$app->action = $action;
        }
    }

    /**
     *
     * @return array ['controller', 'action', 'params']
     */
    private function isIssetRule()
    {
        if ($this->_rule->requestRule($this->_request->isController())) {
            
            return $this->_rule->requestRule($this->_request->isController());

        } else {
            
            return ['controller' => $this->_request->isController(), 'action' => $this->_request->isAction()];
        }

        
    }
}
