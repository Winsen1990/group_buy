<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class OrderDetailDAO extends BaseDAO {
    public $id;
    public $order_sn;
    public $product_sn;
    public $image;
    public $price;
    public $unit;
    public $product_name;
    public $number;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = $this->db->table('order_detail');
        $this->primary_key = 'id';
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
            'order_sn' => $this->order_sn,
            'product_sn' => $this->product_sn,
            'product_name' => $this->product_name,
            'price' => $this->price,
            'unit' => $this->unit,
            'number' => $this->number,
            'image' => $this->image
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($order_sn, $product_sn, $product_name, $price, $unit, $number, $image, $station_id) {
        $data = array(
            'order_sn' => $this->db->escape($order_sn),
            'product_sn' => $this->db->escape($product_sn),
            'product_name' => $this->db->escape($product_name),
            'price' => floatval($price),
            'unit' => $this->db->escape($unit),
            'number' => intval($number),
            'image' => $this->db->escape($image),
            'station_id' => intval($station_id)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_order_detail_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_order_detail_list .= '`'.$column_str.'`';

            if(strpos($get_order_detail_list, '`'.$this->primary_key.'`') === false) {
                $get_order_detail_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_order_detail_list .= '*';
        }

        $get_order_detail_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_order_detail_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_order_detail_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->order_sn = isset($row['order_sn']) ? $row['order_sn'] : null;
            $this->product_sn = isset($row['product_sn']) ? $row['product_sn'] : 0;
            $this->product_name = isset($row['product_name']) ? $row['product_name'] : null;
            $this->price = isset($row['price']) ? $row['price'] : 0;
            $this->unit = isset($row['unit']) ? $row['unit'] : null;
            $this->number = isset($row['number']) ? $row['number'] : 0;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : 0;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('order_detail').' (
            `id` bigint not null auto_increment primary key,
            `station_id` bigint not null comment \'站点ID\',
            `order_sn` varchar(255) not null comment \'订单编号\',
            `product_sn` varchar(255) not null comment \'产品编号\',
            `image` varchar(255) not null comment \'产品图片\',
            `price` decimal(18,2) not null comment \'购买单价\',
            `unit` varchar(255) not null comment \'单位\',
            `product_name` varchar(255) not null comment \'产品名称\',
            `number` int not null comment \'购买数量\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, order_sn:%s, product_sn:%s, product_name:%s, price:%.2f, unit:%s, image:%s, number:%d, station_id:%d }';

        return sprintf($echo_format, $this->id, $this->order_sn, $this->product_sn, $this->product_name, $this->price, $this->unit, $this->image, $this->number, $this->station_id);
    }
}