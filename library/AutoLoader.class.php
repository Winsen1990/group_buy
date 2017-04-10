<?php
/**
 * 自动加载器
 * @author winsen
 * @version 1.0.0
 */
class AutoLoader
{
    private static $obj;
    private $script_path = 'library/';
    private $script_format = '%s.inc.php';
    private $class_path = 'library/';
    private $class_format = '%s.class.php';
    private $plugins_path = 'plugins/';
    private $plugins_format = '%s.class.php';
    private $interface_path = 'interface/';
    private $interface_format = '%s.inf.php';

    /*
     * 构造函数,防止用户通过new创建实例
     * @return AutoLoader AutoLoader的实例
     * @author winsen
     */
    private function __construct()
    {
    }

    /**
     * 获得实例的方法
     * @return AutoLoader AutoLoader的实例
     * @author winsen
     */
    public static function getInstance()
    {
        if(is_null(self::$obj))
        {
            $class = __CLASS__;
            self::$obj = new $class;
        }

        return self::$obj;
    }

    /**
     * 自定义引入文件的格式和路径
     * @param mixed $config 待设置的参数以及取值
     *                      $config = array(
     *                          'script_path' => 'library/',
     *                          'script_format' => '%s.inc.php'
     *                      );
     * @return void
     * @author winsen
     */
    public function set_configs($config)
    {
        if(is_array($config))
        {
            foreach($config as $key=>$value)
            {
                if(isset($this->$key))
                {
                    $this->$key = $value;
                } else {
                    echo 'AutoLoader error: Variable '.$key.' is not exists in AutoLoader.<br/>';
                }
            }
        }
    }

    /**
     * 类加载方法
     * @param string $class 要加载的类名
     * @return void
     * @author winsen
     */
    public function include_classes($class)
    {
        if(is_string($class))
        {
            $file_name = sprintf($this->class_format, $class);
            if(file_exists($this->class_path.$file_name))
            {
                if(!class_exists($class))
                {
                    include($this->class_path.$file_name);
                }
            } else {
                echo 'AutoLoader error: class file:"'.$this->class_path.$file_name.'" dosen\'t exists</br/>';
            }
        }

        if(is_array($class))
        {
            foreach($class as $c)
            {
                if(is_string($c))
                {
                    $file_name = sprintf($this->class_format, $c);
                    if(file_exists($this->class_path.$file_name))
                    {
                        if(!class_exists($c))
                        {
                            include($this->class_path.$file_name);
                        }
                    } else {
                        echo 'AutoLoader error: class file:"'.$this->class_path.$file_name.'" dosen\'t exists.</br/>';
                    }
                }
            }
        }
    }

    /**
     * 插件加载方法
     * @param mixed $plugin 要加载的插件文件夹
     * @return void
     * @author winsen
     */
    public function include_plugins($plugin)
    {
        if(is_string($plugin))
        {
            $document = $plugin;
            if(file_exists($this->plugins_path.$document))
            {
                $dir = dir($this->plugins_path.$document);
                while($file_name = $dir->read()) {
                    $file_name_arr = explode('.', $file_name);
                    $class_name = $file_name_arr[0];

                    if ($file_name != '.' && $file_name != '..' && !class_exists($class_name)) {
                        include($this->plugins_path . $document .'/'.$file_name);
                    }
                }
            } else {
                echo 'AutoLoader error: plugins document:"'.$this->plugins_path.$document.'" dosen\'t exists</br/>';
            }
        }

        if(is_array($plugin))
        {
            foreach($plugin as $c)
            {
                if(is_string($c))
                {
                    $document = $c;
                    if(file_exists($this->plugins_path.$document))
                    {
                        $dir = dir($this->plugins_path.$document);
                        while($file_name = $dir->read()) {
                            $file_name_arr = explode('.', $file_name);
                            $class_name = $file_name_arr[0];

                            if ($file_name != '.' && $file_name != '..' && !class_exists($class_name)) {
                                if(is_file($this->plugins_path . $document .'/'.$file_name)) {
                                    include($this->plugins_path . $document . '/' . $file_name);
                                }
                            }
                        }
                    } else {
                        echo 'AutoLoader error: plugins document:"'.$this->plugins_path.$document.'" dosen\'t exists</br/>';
                    }
                }
            }
        }
    }

    /**
     * 自动加载接口文件
     * @param mixed $identity 文件名
     * @return void
     */
    public function include_interface($identity) {
        if(is_string($identity))
        {
            $file_name = sprintf($this->interface_format, $identity);

            if(file_exists($this->interface_path.$file_name))
            {
                include($this->interface_path.$file_name);
            } else {
                echo 'AutoLoader error: interface file "'.$this->interface_path.$file_name.'" doesn\'t exists.<br/>';
            }
        }

        if(is_array($identity))
        {
            foreach($identity as $script)
            {
                if(is_string($script))
                {
                    $file_name = sprintf($this->interface_format, $script);

                    if(file_exists($this->interface_path.$file_name))
                    {
                        include($this->interface_path.$file_name);
                    } else {
                        echo 'AutoLoader error: interface file "'.$this->interface_path.$file_name.'" doesn\'t exists.</br/>';
                    }
                }
            }
        }
    }

    /**
     * 脚本程序加载方法
     * @param mixed $identity 文件名
     * @return void
     * @author winsen
     */
    public function include_scripts($identity)
    {
        if(is_string($identity))
        {
            $file_name = sprintf($this->script_format, $identity);

            if(file_exists($this->script_path.$file_name))
            {
                include($this->script_path.$file_name);
            } else {
                echo 'AutoLoader error: script file "'.$this->script_path.$file_name.'" doesn\'t exists.<br/>';
            }
        }

        if(is_array($identity))
        {
            foreach($identity as $script)
            {
                if(is_string($script))
                {
                    $file_name = sprintf($this->script_format, $script);

                    if(file_exists($this->script_path.$file_name))
                    {
                        include($this->script_path.$file_name);
                    } else {
                        echo 'AutoLoader error: script file "'.$this->script_path.$file_name.'" doesn\'t exists.</br/>';
                    }
                }
            }
        }
    }
}
