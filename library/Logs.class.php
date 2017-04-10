<?php
/*
 *  日志记录
 *  @author winsen
 *  @version 1.0.1
 */
class Logs
{
    protected $handler;
    protected $debug;
    private $file_path;
    private $mode;

    public function __construct($debug = true, $filename = 'log.log', $file_path = 'logs', $mode = 'pc')
    {
        $this->file_path = $file_path;
        $this->mode = $mode;

        if(!dir($file_path))
        {
            mkdir($file_path);
        }

        $filename = $file_path.'/'.$filename;
        if(!file_exists($filename))
        {
            $tmp = fopen($filename, 'x');
            fclose($tmp);
            chmod($filename, 0755);
        }

        $this->handler = fopen($filename, 'a');
        $this->debug = $debug;
    }

    public function record_array($array)
    {
        if(!$this->debug) return;

        $message = '';
        if(is_array($array) || is_object($array))
        {
            $message = $this->array_to_string($array);
        } else {
            $message = 'object is null.';
        }

        $message = substr($message, 0, strlen($message)-1);
        $formated = '['.$this->mode.']['.date('Y-m-d H:i:s').'] %s'."\n";
        $message = sprintf($formated, $message);

        fwrite($this->handler, $message);
    }

    public function array_to_string($array)
    {
        $str = '';
        if(!is_array($array)) {
            $str .= $array;
        } else {
            foreach($array as $key=>$value)
            {
                $str .= $key.'=';
                if(is_array($value))
                {
                    $tmp = $this->array_to_string($value);
                    $str .= '['.substr($tmp, 0, strlen($tmp)-1).']'."\n";
                } else {
                    $str .= $value;
                }
                $str .= '&';
            }
        }
        return $str;
    }

    public function record($message, $format = true)
    {
        if(!$this->debug) return;

        $formated = '['.$this->mode.']['.date('Y-m-d H:i:s').'] %s'."\n";
        $message = sprintf($formated, $message);

        fwrite($this->handler, $message);
    }

    public function __destruct()
    {
        if($this->handler)
        {
            fclose($this->handler);
        }
    }
}
