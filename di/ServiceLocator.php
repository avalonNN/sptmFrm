<?php
namespace sptmFrm\di;

use sptmFrm\base\Application;

/**
 * Description of ServiceLocator
 *
 * @author aciden
 */
abstract class ServiceLocator
{
    /**
     *
     * @var type
     */
    private $_mapServices = [];

    /**
     *
     * @var type
     */
    private $_services = [];

    /**
     *
     * @param type $name
     * @return type
     */
    public function get($name)
    {
        if (isset($this->_mapServices[$name]) && !isset($this->_services[$name])) {

            return $this->_services[$name] = Application::createObject($this->_mapServices[$name]);

        } elseif(isset($this->_services[$name])) {
            
            return $service = $this->_services[$name];
        }
    }

    /**
     *
     * @return type
     */
    public function getMap()
    {
        return (empty($this->_mapServices)) ? $this->setMap() : $this->_mapServices;
    }

    /**
     *
     */
    public function setMap()
    {
        $this->_mapServices = require_once(SOFT_PATH . 'listServices.php');
    }
}
