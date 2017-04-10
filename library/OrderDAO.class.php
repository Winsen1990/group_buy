<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class OrderDAO extends BaseDAO {
    public $id;
    public $order_sn;
    public $add_time;
    public $pay_time;
    public $pay_type;
    public $delivery_type;
    public $delivery_fee;
    public $delivery_code;
    public $delivery_sn;
    public $delivery_time;
    public $delivery_name;
    public $order_amount;
    public $coupon_amount;
    public $product_amount;
    public $account;
    public $status;
    public $remark;
    public $group_sn;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = $this->db->table('order');
        $this->primary_key = 'order_sn';
    }

    public function delete($condition) {
        $delete_order_detail = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_order_detail .= ' where '.$condition;
        }

        return $this->db->delete($delete_order_detail);
    }

    public function save() {
        $data = array(
            'pay_type' => $this->pay_type,
            'pay_time' => $this->pay_time,
            'delivery_sn' => $this->delivery_sn,
            'delivery_code' => $this->delivery_code,
            'delivery_name' => $this->delivery_name,
            'delivery_time' => $this->delivery_time,
            'delivery_fee' => $this->delivery_fee,
            'order_amount' => $this->order_amount,
            'product_amount' => $this->product_amount,
            'coupon_amount' => $this->coupon_amount,
            'account' => $this->account,
            'status' => $this->status,
            'remark' => $this->remark,
            'group_sn' => $this->group_sn,
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($station_id, $account, $product_amount, $coupon_amount, $delivery_fee, $pay_type, $delivery_type,
                        $group_sn = '', $remark = '', $order_sn = '', $status = 1, $pay_time = '', $delivery_time = '',
                        $delivery_name = '', $delivery_code = '', $delivery_sn = '') {

        if($order_sn == '') {
            $order_sn = $this->generate_sn();
        } else {
            $order_sn = $this->db->escape($order_sn);
        }

        $data = array(
            'order_sn' => $order_sn,
            'account' => $this->db->escape($account),
            'product_amount' => floatval($product_amount),
            'coupon_amount' => floatval($coupon_amount),
            'order_amount' => floatval($product_amount + $delivery_fee - $coupon_amount),
            'delivery_fee' => floatval($delivery_fee),
            'pay_type' => $this->db->escape($pay_type),
            'delivery_type' => $this->db->escape($delivery_type),
            'group_sn' => $this->db->escape($group_sn),
            'remark' => $this->db->escape($remark),
            'pay_time' => $this->db->escape($pay_time),
            'delivery_time' => $this->db->escape($delivery_time),
            'delivery_name' => $this->db->escape($delivery_name),
            'delivery_code' => $this->db->escape($delivery_code),
            'delivery_sn' => $this->db->escape($delivery_sn),
            'status' => intval($status),
            'add_time' => date('Y-m-d H:i:s'),
            'station_id' => intval($station_id)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_order_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_order_list .= '`'.$column_str.'`';

            if(strpos($get_order_list, '`'.$this->primary_key.'`') === false) {
                $get_order_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_order_list .= '*';
        }

        $get_order_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_order_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_order_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->order_sn = isset($row['order_sn']) ? $row['order_sn'] : null;
            $this->add_time = isset($row['add_time']) ? $row['add_time'] : null;
            $this->pay_time = isset($row['pay_time']) ? $row['pay_time'] : null;
            $this->pay_type = isset($row['pay_type']) ? $row['pay_type'] : null;
            $this->delivery_type = isset($row['delivery_type']) ? $row['delivery_type'] : null;
            $this->delivery_time = isset($row['delivery_time']) ? $row['delivery_time'] : null;
            $this->delivery_name = isset($row['delivery_name']) ? $row['delivery_name'] : null;
            $this->delivery_sn = isset($row['delivery_sn']) ? $row['delivery_sn'] : null;
            $this->delivery_code = isset($row['delivery_code']) ? $row['delivery_code'] : null;
            $this->delivery_fee = isset($row['delivery_fee']) ? $row['delivery_fee'] : null;
            $this->order_amount = isset($row['order_amount']) ? $row['order_amount'] : null;
            $this->product_amount = isset($row['product_amount']) ? $row['product_amount'] : null;
            $this->coupon_amount = isset($row['coupon_amount']) ? $row['coupon_amount'] : null;
            $this->group_sn = isset($row['group_sn']) ? $row['group_sn'] : null;
            $this->status = isset($row['status']) ? $row['status'] : null;
            $this->account = isset($row['account']) ? $row['account'] : null;
            $this->remark= isset($row['remark']) ? $row['remark'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('order').' (
            `id` bigint not null auto_increment unique,
            `station_id` bigint not null comment \'站点ID\',
            `order_sn` varchar(255) not null primary key comment \'订单编号\',
            `add_time` datetime not null comment \'下单时间\',
            `pay_time` datetime comment \'支付时间\',
            `pay_type` varchar(255) not null comment \'支付方式\',
            `delivery_type` varchar(255) not null comment \'物流方式\',
            `delivery_time` datetime comment \'发货时间\',
            `delivery_name` varchar(255) comment \'快递公司\',
            `delivery_sn` varchar(255) comment \'快递单号\',
            `delivery_code` varchar(255) comment \'快递公司代码\',
            `delivery_fee` decimal(18,2) not null default \'0\' comment \'订单运费\',
            `order_amount` decimal(18,2) not null default \'0\' comment \'订单总额\',
            `product_amount` decimal(18,2) not null default \'0\' comment \'产品总额\',
            `coupon_amount` decimal(18,2) not null default \'0\' comment \'优惠券总额\',
            `group_sn` varchar(255) comment \'拼团编号\',
            `status` int not null default \'1\' comment \'订单编号\',
            `account` varchar(255) not null comment \'会员账号\',
            `remark` varchar(255) comment \'备注\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function generate_sn() {
        $begin = 1;
        $max = pow(10, ORDER_SN_TAIL_LENGTH);
        $step = $max/4 < 1000 ? intval($max/4) : 999;
        $order_sn = '';
        $order_sn_pre = date(ORDER_SN_FORMAT);

        do {
            $end = $begin + $step;
            $sn_arr = range($begin, $end);
            $begin = $end++;

            $sn = array_shift($sn_arr);
            $cnt = ORDER_SN_TAIL_LENGTH;
            $cnt = $cnt - strlen($sn);
            while($cnt >= 1) {
                $sn = '0'.$sn;
            }

            $check_order_sn = 'select `order_sn` from `'.$this->__name.'` where `order_sn`=\''.$order_sn_pre.$sn.'\'';

            if(!$this->db->fetch_one($check_order_sn)) {
                $order_sn = $order_sn_pre.$sn;
                break;
            }
        } while($end <= $max);

        return $order_sn;
    }

    public function __toString() {
        $echo_format = '{ id:%d, order_sn:%s, add_time:%d, pay_time:%s, pay_type:%s, delivery_type:%s, delivery_time:%s,
                          delivery_name:%s, delivery_sn:%s, delivery_code:%s, delivery_fee:%.2f, order_amount:%.2f,
                          product_amount:%.2f, coupon_amount:%.2f, group_sn:%s, status:%d, account:%s, remark:%s,
                          station_id:%d }';

        return sprintf($echo_format, $this->id, $this->order_sn, $this->add_time, $this->pay_time, $this->pay_type,
                       $this->delivery_type, $this->delivery_time, $this->delivery_name, $this->delivery_sn,
                       $this->delivery_code, $this->delivery_fee, $this->order_amount, $this->product_amount,
                       $this->coupon_amount, $this->group_sn, $this->status, $this->account, $this->remark,
                       $this->station_id);
    }
}