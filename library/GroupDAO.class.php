<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class GroupDAO extends BaseDAO {
    public $id;
    public $group_sn;
    public $status;
    public $add_time;
    public $expired;
    public $member_limit;
    public $current_number;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = $this->db->table('group');
        $this->primary_key = 'group_sn';
    }

    public function delete($condition) {
        $delete_group = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_group .= ' where '.$condition;
        }

        return $this->db->delete($delete_group);
    }

    public function save() {
        $data = array(
            'status' => $this->status,
            'expired' => $this->expired,
            'member_limit' => $this->member_limit,
            'current_number' => $this->current_number
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($member_limit, $current_number, $expired, $group_sn = '', $status = 1) {
        if($group_sn == '') {
            $group_sn = $this->generate_sn();
        } else {
            $group_sn = $this->db->escape($group_sn);
        }

        $data = array(
            'group_sn' => $group_sn,
            'member_limit' => intval($member_limit),
            'current_number' => intval($current_number),
            'expired' => $this->db->escape($expired),
            'status' => intval($status)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_category_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_category_list .= '`'.$column_str.'`';

            if(strpos($get_category_list, '`'.$this->primary_key.'`') === false) {
                $get_category_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_category_list .= '*';
        }

        $get_category_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_category_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_category_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->group_sn = isset($row['group_sn']) ? $row['group_sn'] : null;
            $this->status = isset($row['status']) ? $row['status'] : 0;
            $this->add_time = isset($row['add_time']) ? $row['add_time'] : null;
            $this->expired = isset($row['expired']) ? $row['expired'] : null;
            $this->member_limit = isset($row['member_limit']) ? $row['member_limit'] : null;
            $this->current_number = isset($row['current_number']) ? $row['current_number'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('group').' (
            `id` bigint not null auto_increment unique,
            `group_sn` varchar(255) not null primary key comment \'团编号\',
            `status` int not null default \'1\' comment \'团状态\',
            `add_time` datetime not null comment \'创建时间\',
            `expired` datetime not null comment \'过期时间\',
            `member_number` int not null comment \'团成员数量\',
            `current_number` int not null comment \'目前团人数\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function generate_sn() {
        $begin = 1;
        $max = pow(10, GROUP_SN_TAIL_LENGTH);
        $step = $max/4 < 1000 ? intval($max/4) : 999;
        $group_sn = '';
        $group_sn_pre = date(GROUP_SN_FORMAT);

        do {
            $end = $begin + $step;
            $sn_arr = range($begin, $end);
            $begin = $end++;

            $sn = array_shift($sn_arr);
            $cnt = GROUP_SN_TAIL_LENGTH;
            $cnt = $cnt - strlen($sn);
            while($cnt >= 1) {
                $sn = '0'.$sn;
            }

            $check_group_sn = 'select `group_sn` from `'.$this->__name.'` where `group_sn`=\''.$group_sn_pre.$sn.'\'';

            if(!$this->db->fetch_one($check_group_sn)) {
                $group_sn = $group_sn_pre.$sn;
                break;
            }
        } while($end <= $max);

        return $group_sn;
    }

    public function __toString() {
        $echo_format = '{ id:%d, group_sn:%s, member_limit:%d, current_number:%d, add_time:%s, expired:%s, status:%d }';

        return sprintf($echo_format, $this->id, $this->group_sn, $this->member_limit, $this->current_number,
                       $this->add_time, $this->expired, $this->status);
    }
}