<?php

namespace icc\request;

use icc\request\HttpRequest;
use icc\log\Log;

/**
 * Description of Request
 *
 * @author aciden
 */
class Request
{
    /**
     *
     * @var type
     */
    private $_handleRequest;

    /**
     *
     * @var type
     */
    private $_request = [];

    /**
     *
     */
    private $_params = [];

    /**
     *
     */
    private $_proccesParams = [];

    /**
     * ключ массива параметров если есть правила для urlManager
     */
    const PARAMS_WITH_RULE = 1;

    /**
     * ключ массива параметров без правил urlManager
     */
    const PARAMS_WITHOUT_RULE = 2;

    /**
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->_handleRequest = $request;
        
        $this->setArrayRequest();

        Log::record('trace', 'Обработка входного параметра (' . implode('/', $this->getArrayRequest()) . ')');
    }

    /**
     *
     * @return type
     */
    public function getArrayRequest()
    {
        return $this->_request;
    }

    /**
     *
     */
    public function setArrayRequest()
    {
        $this->_request = $this->_handleRequest->execute();
    }

    /**
     *
     * @param type $rule
     */
    public function setArrayParams($rule = null)
    {
        if ($rule !== null && $this->isExistsParam(self::PARAMS_WITH_RULE)) {
            $this->_proccesParams = $this->isRuleParams($rule, array_slice($this->_request, self::PARAMS_WITH_RULE));

        } elseif ($this->isExistsParam(self::PARAMS_WITHOUT_RULE)) {
            
            $this->_proccesParams = $this->isNotRuleParams(array_slice($this->_request, self::PARAMS_WITHOUT_RULE));
        }
    }

    /**
     *
     * @param type $rule
     */
    public function getArrayParams()
    {
        return $this->_proccesParams + array_merge($this->_handleRequest->getGet(), $this->_handleRequest->getPost());
    }

    /**
     *
     * @param array $params
     * @return array
     */
    public function isNotRuleParams($params)
    {
        $key = [];
        $value = [];

        for ($i = 0; $i<=count($params); $i++) {
            
            if ($i == 0 || !($i & 1)) {
                
                if (empty($params[$i])){
                    break;
                }
                $key[] = $params[$i];
                
            } else {

                $value[] = isset($params[$i]) ? $params[$i] : 'true';
            }
        }

        return array_combine($key, $value);
    }

    /**
     *
     * @param array $rule
     * @param array $params
     * @return array params
     */
    public function isRuleParams($rule, $params)
    {
        $countRule = count($rule);
        $countParams = count($params);

        if ($countRule == $countParams) {

            return array_combine($rule, $params);

        } elseif ($countRule > $countParams) {

            $odds = $countRule - $countParams;
            $rule = array_slice($rule, 0, -$odds);
            
            return array_combine($rule, $params);
            
        } elseif ($countRule < $countParams) {

            $odds = $countParams - $countRule;
            $onParams = array_slice($params, 0, -$odds);

            return array_combine($rule, $onParams) + $this->isNotRuleParams(array_slice($params, $countRule));
        }
        
    }

    public function isController()
    {
        if (isset($this->_request[0]) && !empty($this->_request[0])) {

            return $this->_request[0];
        }

        return null;
    }

    public function isAction()
    {
        if (isset($this->_request[1])) {
            
            return $this->_request[1];
        }
        
        return null;
    }

        /**
     *
     * @param type $val
     * @return boolean
     */
    public function isExistsParam($val)
    {
        if (isset($this->_request[$val])) {
            
            return true;

        } else {

            return false;
        }
    }
}
