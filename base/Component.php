<?php

namespace sptmFrm\base;

use sptmFrm\di\ServiceLocator;


/**
 * Description of Component
 *
 * @author aciden
 */
class Component extends ServiceLocator
{
    /**
     * Компоненты из конфигурационного файла
     *
     * @var array
     */
    private $_components = [];
    /**
     *
     * @param type $name
     * @return type
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        // Если метода не существует ищем раннее созданный объект или создаём новый или возвращаем ошибку
        if (method_exists($this, $method)) {

            return $this->$method();

        } else {

            return parent::get($name);
        }
    }

    public function __set($name, $value)
    {
        return null;
    }

    /**
     * Запись компонентов
     *
     * @param array $components
     */
    protected function setComponents($components = [])
    {
        $this->_components = array_replace_recursive($this->_components, $components);

        foreach (parent::getMap() as $key=>$value) {

            if (isset($components[$key])) {

                Application::$container->config[$value] = $components[$key];

            } else {

                Application::$container->config[$value] = [];
            }
        }
    }

    /**
     * Извлечение компонентов по имени массива
     *
     * @param string $name
     * @return array
     */
    public function getComponents($name)
    {
        return empty($this->_components[$name]) ? null : $this->_components[$name];
    }
}
