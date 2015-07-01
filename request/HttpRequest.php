<?php

namespace sptmFrm\request;

/**
 * Description of baseRequest
 *
 * @author aciden
 */
class HttpRequest extends CommandRequest
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
    private $_post = [];

    /**
     *
     * @var type 
     */
    private $_get = [];

    /**
     * 
     */
    public function __construct()
    {
        $this->_request = explode('?', filter_input(INPUT_SERVER, 'REQUEST_URI'));

        $this->isPost($_POST);

        $this->isGet($_GET);
    }

    /**
     *
     * @return type
     */
    public function execute()
    {
        return explode('/', trim($this->_request[0], '/'));
    }

    /**
     *
     * @param type $post
     * @return null3
     */
    private function isPost($post)
    {
        if (!empty($post)) {

            $this->setPost($post);

        } else {
            
            return null;
        }
    }

    /**
     *
     * @param type $post
     */
    private function setPost($post)
    {
        $this->_post = $post;
    }

    /**
     *
     * @return type
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     *
     * @param type $get
     * @return type
     */
    private function isGet($get)
    {
        if (!empty($get)) {

            $this->setGet($get);

        } else {

            return null;
        }
    }

    /**
     *
     * @param type $get
     */
    private function setGet($get)
    {
        $this->_get = $get;
    }

    /**
     *
     * @return type
     */
    public function getGet()
    {
        return $this->_get;
    }
}
