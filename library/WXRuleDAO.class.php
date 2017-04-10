<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/7/19
 * Time: 下午6:23
 */
class WXRuleDAO extends BaseDAO {
    public $id;
    public $rule;
    public $match_mode;
    public $response_id;
    public $sort;
    public $is_default;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = $this->db->table('rules');
        $this->primary_key = 'id';
    }

    public function delete($condition) {
        $delete_rules = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_rules .= ' where '.$condition;
        }

        return $this->db->delete($delete_rules);
    }

    public function save() {
        if($this->is_default) {
            $this->db->auto_update($this->__name, array('is_default'=>0));
        }

        $data = array(
            'rule' => $this->rule,
            'match_mode' => $this->match_mode,
            'response_id' => $this->response_id,
            'sort' => $this->sort,
            'is_default' => $this->is_default
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($rule, $response_id, $station_id, $match_mode = 0, $is_default = 0, $sort = 50) {
        $data = array(
            'rule' => $this->db->escape($rule),
            'response_id' => intval($response_id),
            'match_mode' => intval($match_mode),
            'is_default' => intval($is_default),
            'sort' => intval($sort),
            'station_id' => intval($station_id)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_rule_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_rule_list .= '`'.$column_str.'`';

            if(strpos($get_rule_list, '`id`') === false) {
                $get_rule_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_rule_list .= '*';
        }

        $get_rule_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_rule_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_rule_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->rule = isset($row['rule']) ? $row['rule'] : null;
            $this->match_mode = isset($row['match_mode']) ? $row['match_mode'] : false;
            $this->response_id = isset($row['response_id']) ? $row['response_id'] : null;
            $this->sort = isset($row['sort']) ? $row['sort'] : null;
            $this->is_default = isset($row['is_default']) ? $row['is_default'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('wx_rules').' (
            `id` bigint not null auto_increment primary key,
            `station_id` bigint not null comment \'站点ID\',
            `rule` varchar(255) not null comment \'规则\',
            `match_mode` tinyint(1) not null default \'0\' comment \'匹配模式\',
            `response_id` int not null comment \'响应ID\',
            `sort` int not null default \'50\' comment \'排序\',
            `is_default` tinyint(1) not null default \'0\ comment \'默认回复\'
        ) default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, response_id:%d, match_mode:%d, rule:"%s", sort:%d, is_default:%d, station_id:%d }';

        return sprintf($echo_format, $this->id, $this->response_id, $this->match_mode, $this->rule, $this->sort, $this->is_default, $this->station_id);
    }
}