<?php
namespace sptmFrm\view;

use sptmFrm\exception\FileException;
use sptmFrm\base\Application;

/**
 * Description of View
 *
 * @author aciden
 */
class View
{
    /**
     *
     * @param type $fileRender
     * @param type $params
     * @throws FileException
     */
    public function renderLayout($fileRender, $params = [])
    {

        $view = APP_PATH . 'views' . DIRECTORY_SEPARATOR . Application::$app->theme . DIRECTORY_SEPARATOR . Application::$app->layout . Application::$app->extension;
        $fileRender = APP_PATH . 'views' . DIRECTORY_SEPARATOR . Application::$app->dirRender . DIRECTORY_SEPARATOR . $fileRender . Application::$app->extension;


        if (!file_exists($view)) {
            throw new FileException('File general template not found. Please create file `'.$view.'`');
            
        } else {

            $content = $this->getContent($fileRender, $params);
            
            return $this->getContent($view, ['content' => $content]);
        }
    }

    /**
     *
     * @param string $file
     * @param array $params
     * @return string render file
     */
    public function getContent($file, $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($file);
        
        return ob_get_clean();
    }
}
