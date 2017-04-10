<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/7/14
 * Time: 下午6:40
 */
abstract class BaseDAO {
    protected $db;
    protected $primary_key;
    protected $__name;
    protected $res;

    public function __construct() {
        $this->db = MySQL::get_instance();
    }

    public function delete($condition) {
        $delete_sql = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_sql .= ' where '.$condition;
        }

        return $this->db->delete($delete_sql);
    }

    public function get($where_condition, $columns = array()) {
        $get_row = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_row .= '`'.$column_str.'`';

            if(strpos($get_row, '`'.$this->primary_key.'`') === false) {
                $get_row .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_row .= '*';
        }

        $get_row .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_row .= ' where 1 and ' . $where_condition;
        }

        $get_row .= ' limit 1';
        $this->res = $this->db->query($get_row);

        return $this->next();
    }

    abstract function next();
    abstract function save();
}