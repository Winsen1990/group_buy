<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/7/19
 * Time: 下午5:05
 */
class WechatReply {
    protected $db;
    protected $request_handler;

    public function __construct($db) {
        $this->db = $db;
    }

    public function validate() {
        return true;
    }

    public function get_response($request) {

    }

    public function set_request_handler($request_handler) {
        $this->request_handler = $request_handler;
    }
}