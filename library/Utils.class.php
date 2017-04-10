<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/7
 * Time: 下午6:29
 */
class Utils {
    protected $raw_data;
    protected $decode_mode;
    protected $encode_mode;
    public $request;
    public $response;
    private static $_obj;

    private function __construct($encode_mode = 'json', $decode_mode = 'json') {
        $this->decode_mode = $decode_mode;
        $this->encode_mode = $encode_mode;
    }

    public static function get_instance($encode_mode = 'json', $decode_mode = 'json') {
        if(isset(self::$_obj)) {
            return self::$_obj;
        }

        return new Utils($encode_mode, $decode_mode);
    }

    public function validation() {
        if(is_array($this->raw_data) && count($this->raw_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function request($data) {
        $this->raw_data = $data;
        if($this->validation()) {
            switch($this->decode_mode) {
                default:
                    $this->request = json_decode($this->raw_data['data']);
            }
        }

        return $this->request;
    }

    public function response($data) {
        $this->raw_data = $data;

        switch($this->encode_mode) {
            default:
                $this->response = json_encode($this->raw_data);
        }

        return $this->response;
    }
}