<?php
namespace icc\helpers;

/**
 * Description of Html
 *
 * @author aciden
 */
class Html
{
    /**
     *
     * @param type $method
     * @param type $action
     * @param type $param
     * @return string
     */
    public function openForm($method = 'post', $action = '', $param = [])
    {
        $form = '<form method="' . $method . '" action="' . $action . '">';

        return $form;
    }

    /**
     *
     * @param type $name
     * @param array $value
     * @param array $options
     * @return type
     */
    public function textForm($name = null, $value = null, array $options = [])
    {
        $option = null;

        foreach ($options as $key=>$value) {
            $option .= $key . '="' . $value . '"';
        }

        return '<input type="text" name="' . $name . '" value="' . $value . '" ' . $option . ' />';
    }

    /**
     *
     * @param type $value
     * @return type
     */
    public function submitForm($value = 'submit')
    {
        return '<input type="submit" value="' . $value . '" />';
    }

    /**
     *
     * @return string
     */
    public function closeForm()
    {
        return '</form>';
    }
}