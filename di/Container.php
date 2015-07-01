<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace sptmFrm\di;

use sptmFrm\exception\AppException;
use sptmFrm\base\Application;

/**
 * Description of Container
 *
 * @author aciden
 */
class Container
{
    /**
     *
     * @var array
     */
    private $_dependencies = [];

    /**
     *
     * @var array
     */
    private $_reflection = [];
    
    /**
     *
     * @var array
     */
    public $config = [];

    /**
     *
     * @var type 
     */
    private $_container = [];


    /**
     *
     * @param type $class
     * @param type $params
     * @return type
     */
    public function get($class)
    {
        if (isset($this->config[$class]['class'])) {
            $class = $this->config[$class]['class'];
        }

        if (isset($this->_container[$class]) && !empty($this->_container[$class])) {

            return $this->_container[$class];

        } else {
            $config = isset($this->config[$class]) ? $this->config[$class] : null;
            list($dependencies, $reflection) = $this->getDependencies($class, $config);
            $object = $this->build($dependencies, $reflection, $class);

            return $object;
        }
    }

    /**
     *
     * @param type $class
     * @param type $params
     * @return type
     */
    public function getDependencies($class, $params = null)
    {
        if (isset($this->_dependencies[$class])) {
            return [$this->_dependencies[$class], $this->_reflection[$class]];
        }
        
        $dependencies = [];
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                if ($param->isDefaultValueAvailable() && $param->getDefaultValue() != null) {
                    $dependencies[] =  $param->getDefaultValue();

                } else {

                    $cl = $param->getClass();
                    if ($cl) {
                        $dependencies[] = $this->get($cl->getName());

                    } else {

                        if (isset($params[$param->getName()])) {
                            $dependencies[] = $params[$param->getName()];

                        } else {
                            
                            throw new AppException('Нет данных для обязательного параметра (' . $param->getName() . ') конструктора класса - ' . $class);
                        }
                    }
                }
            }
        }

        $this->_dependencies[$class] = $dependencies;
        $this->_reflection[$class] = $reflection;

        return [$dependencies, $reflection];
    }
    
    /**
     *
     * @param type $dependecies
     * @param type $reflection
     * @return type
     */
    public function build($dependecies, $reflection, $class)
    {
        return $this->_container[$class] = $reflection->newInstanceArgs($dependecies);
    }
}
