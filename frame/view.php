<?php

class View 
{
    private static $_instance = null;

	/**
     * 模板变量
     * @var array
     */
    protected static $data = [];

    public static function getInstance() 
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function display($template = '')
    {
        $template = $this->getTemplate($template);

        if (!file_exists($template)) {
            throw new Exception($template . ' 模板不存在', 1);
        }

        extract(self::$data);
        self::$data = [];

        include($template);
    }

    private function getTemplate($template) 
    {
        if (!empty($template)) {
            if (false === strrpos($template, '/')) {
                $template = \Router::realFunc(explode('.', $template));
                $temp = \Router::getFunc();
                switch (count($template)) {
                    case 1:
                        $temp['Func'] = $template[0] ?? 'index';
                        break;
                    case 2:
                        $temp['Func'] = $template[1] ?? 'index';
                        $temp['ClassPath'] = $template[0] ?? 'Index';
                        break;
                    default:
                        $temp['Class'] = array_shift($template);
                        $temp['Func'] = array_pop($template);
                        $temp['ClassPath'] = implode('/', $template);
                        break;
                }

                $template = 'view/' . (isMobile() ? 'Mobile' : 'Computer') . '/' . implode('/', $temp);
            }
        } else {
            $template = 'view/' . (isMobile() ? 'Mobile' : 'Computer') . '/' . implode('/', \Router::getFunc());
        }

        return ROOT_PATH . $template . '.php';
    }

    public function fetch($template = '', $cachelate = '')
    {
        ob_start();

        $this->display($template);

        $content = ob_get_clean();

        if (!empty($cachelate)) {

        }

        echo $content;
    }

    public function assign($name, $value = null)
    {
        if (is_array($name)) {
            self::$data = array_merge(self::$data, $name);
        } else {
            self::$data[$name] = $value;
        }
        return $this;
    }

    public static function load($template = '')
    {
        if (empty($template)) return false;

        $template = self::getInstance()->getTemplate($template);

        if (!file_exists($template)) {
            throw new Exception($template . ' 模板不存在', 1);
        }

        extract(self::$data);

        include($template);
    }
}