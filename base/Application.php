<?php
namespace sptmFrm\base;

use sptmFrm\exception\ControllerException;
use sptmFrm\base\Component;
use sptmFrm\di\Container;
use sptmFrm\log\Log;

/**
 * Основной класс работы приложения
 * Запускает указанный в адресной строке или дефолтный контроллер и действие.
 *
 * @author aciden
 * @copyright (c) 2014, SPTM
 */
class Application extends Component
{
    /**
     *
     * @var type 
     */
    public $version = '0.0.1';

    /**
     *
     * @var type
     */
    public $controller = 'Default';
    
    /**
     *
     * @var type
     */
    public $action = 'Index';

    /**
     *
     * @var type
     */
    public $name = 'Icc framework';

    /**
     * Пространство имен для контроллеров приложения
     * 
     * @var string $nameSpaceControllers namespace controllers app
     */
    private $_nameSpaceControllers = 'sptmFrm\\controllers\\';
    
    /**
     * Главный файл HTML шаблона
     * 
     * @var string $layout Default name layout
     */
    public $layout = 'main';
    
    /**
     * Тема по умолчанию
     * 
     * @var string $theme Default theme
     */
    public $theme;
        
    /**
     * Расширение файлов представления
     * 
     * @var string default extension
     */
    private $_extensionLayout = '.php';

    /**
     *
     * @var type
     */
    private $_config;

    /**
     *
     * @var type
     */
    public static $app;

    /**
     *
     * @var type
     */
    public $params = [];

    /**
     *
     * @var type 
     */
    public static $container;

    /**
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        Log::record('trace', 'Инициализация скрипта. ' . __METHOD__);

        self::$app = $this;

        $this->_config = $config;
        
        $this->init();
    }
    
    /**
     * 
     */
    public function init()
    {

        self::$container = new Container();
        $this->setTheme();
        $this->getMap();
        $this->setComponents($this->_config['components']);

        $this->registerException()->register();
        $this->handlerLog();

    }
    
    /**
     * Запуск
     *  
     */
    public function startApp()
    {
        try {
            $time = microtime(true);

            $this->handleRequest($this->getRoute());
            $this->runController();
            
            $time = round(microtime(true) - $time, 3);
            
            Log::record('trace', 'Завершено удачно. Использованно памяти - '
                . round(memory_get_peak_usage() / 1024 / 1024, 3)
                . 'Mb. Время создания странницы - ' . $time . 'c');
            
        } catch (StopException $e) {

        }
    }

    /**
     *
     * @param \sptmFrm\base\request\Request $request
     */
    public function handleRequest()
    {
        //var_dump($this->getRequest()->getArrayParams());
    }

    /**
     *
     * @return controller
     */
    private function runController()
    {
        $runController = $this->_nameSpaceControllers . ucfirst($this->controller) . 'Controller';
        Log::record('trace', 'Инициализирован контроллер: ' . $this->controller);

        $runAction = 'action' . ucfirst($this->action);
        Log::record('trace', 'Инициализирован метод: ' . $this->action);

        if (class_exists($runController)) {

            if (method_exists($runController, $runAction)) {

                Log::record('trace', 'Запуск метода ' . $runAction . ', в контроллере ' . $runController );
                
                return self::createObject([$runController, $runAction], $this->getRequest()->getArrayParams());

            } else {

                throw new ControllerException('Не найден метод - ' . $runAction . ', в контроллере - ' .  $runController);
            }

        } else {

            throw new ControllerException('Не найден контроллер - ' . $runController);
        }

        return false;
    }

    /**
     * @return string home url
     */
    public function getHomeUrl()
    {
        return 'http://' . filter_input(INPUT_SERVER, 'SERVER_NAME');
    }
    
    /**
     * 
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     *
     */
    private function setTheme()
    {
        if (isset($this->_config['theme']) && !empty($this->_config['theme'])) {
            $this->theme = $this->_config['theme'];
        }
    }

    /**
     *
     * @return type
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     *
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return type
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Returns the route component.
     *
     * @return \sptmFrm\base\route\Route
     */
    public function getRoute()
    {
        return $this->get('route');
    }

    /**
     * Returns the request component.
     *
     * @return \sptmFrm\base\request\Request
     */
    public function getRequest()
    {
        return $this->get('request');
    }

    /**
     * 
     * @return \sptmFrm\base\UrlManager
     */
    public function getUrlManager()
    {
        return $this->get('urlManager');
    }

    /**
     *
     * @return \sptmFrm\base\template\View
     */
    public function getView()
    {
        return $this->get('view');
    }

    /**
     *
     * @return string dir render file
     */
    public function getDirRender()
    {
        return $this->theme . DIRECTORY_SEPARATOR . strtolower($this->controller);
    }

    /**
     *
     * @return type
     */
    public function getExtension()
    {
        return $this->_extensionLayout;
    }

    /**
     *
     * @return object
     */
    public function handlerLog()
    {
        return $this->get('log');
    }

    public function registerException()
    {
        return $this->get('errorHandler');
    }

    /**
     *
     * @param type $class
     * @param type $params
     * @return object
     */
    public static function createObject($class, $params = [])
    {
        if (is_string($class)) {
            $object = Application::$container->get($class, $params);

        } elseif (is_array($class)) {

            $object = call_user_func([self::createObject($class[0]), $class[1]], $params);

        }

        return $object;
    }
}
