<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class PriceListDAO extends BaseDAO {
    public $id;
    public $product_sn;
    public $price;
    public $min_number;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = $this->db->table('price_list');
        $this->primary_key = 'id';
    }

    public function delete($condition) {
        $delete_price_list = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_price_list .= ' where '.$condition;
        }

        return $this->db->delete($delete_price_list);
    }

    public function save() {
        $data = array(
            'product_sn' => $this->product_sn,
            'price' => $this->price,
            'min_number' => $this->min_number
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($product_sn, $min_number, $price, $station_id) {
        $data = array(
            'product_sn' => $this->db->escape($product_sn),
            'min_number' => intval($min_number),
            'price' => floatval($price),
            'station_id' => intval($station_id)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_price_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_price_list .= '`'.$column_str.'`';

            if(strpos($get_price_list, '`'.$this->primary_key.'`') === false) {
                $get_price_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_price_list .= '*';
        }

        $get_price_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_price_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_price_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->product_sn = isset($row['product_sn']) ? $row['product_sn'] : null;
            $this->price = isset($row['price']) ? $row['price'] : null;
            $this->min_number = isset($row['min_number']) ? $row['min_number'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('price_list').' (
            `id` bigint not null auto_increment primary key,
            `station_id` bigint not null comment \'站点ID\',
            `product_sn` varchar(255) not null comment \'商品编号\',
            `min_number` int not null comment \'最低购买量\',
            `price` decimal(18,2) not null comment \'价格\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, price:%.2f, min_number:%d, product_sn:%s, station_id:%d }';

        return sprintf($echo_format, $this->id, $this->price, $this->min_number, $this->product_sn, $this->station_id);
    }
}