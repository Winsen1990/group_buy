<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class ProductDAO extends BaseDAO {
    public $id;
    public $product_sn;
    public $status;
    public $name;
    public $category_id;
    public $brand_id;
    public $image;
    public $thumb;
    public $market_price;
    public $price;
    public $group_limit;
    public $group_price;
    public $detail;
    public $unit;
    public $desc;
    public $add_time;
    public $station_id;
    public $sort;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = 'product';
        $this->primary_key = 'product_sn';
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
            'status' => $this->status,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'image' => $this->image,
            'thumb' => $this->thumb,
            'market_price' => $this->market_price,
            'price' => $this->price,
            'group_limit' => $this->group_limit,
            'group_price' => $this->group_price,
            'detail' => $this->detail,
            'unit' => $this->unit,
            'desc' => $this->desc,
            'sort' => $this->sort,
            'brand_id' => $this->brand_id
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`=\''.$this->{$this->primary_key}.'\'');
    }

    public function get($where_condition, $columns = array()) {
        $get_section = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_section .= '`'.$column_str.'`';

            if(strpos($get_section, '`'.$this->primary_key.'`') === false) {
                $get_section .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_section .= '*';
        }

        $get_section .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_section .= ' where 1 and ' . $where_condition;
        }

        $get_section .= ' limit 1';
        $this->res = $this->db->query($get_section);

        return $this->next();
    }

    public function add($name, $category_id, $market_price, $price, $group_limit, $group_price, $image,
                        $thumb, $detail, $desc, $unit, $station_id, $sort = 50, $status = 1, $brand_id = 0, $product_sn = '') {
        if($product_sn == '') {
            $product_sn = $this->generate_sn();
        } else {
            $product_sn = $this->db->escape($product_sn);
        }

        $data = array(
            'product_sn' => $product_sn,
            'status' => intval($status),
            'category_id' => intval($category_id),
            'name' => $this->db->escape($name),
            'image' => $this->db->escape($image),
            'thumb' => $this->db->escape($thumb),
            'market_price' => $market_price,
            'price' => floatval($price),
            'group_limit' => floatval($group_limit),
            'group_price' => floatval($group_price),
            'detail' => $this->db->escape($detail),
            'desc' => $this->db->escape($desc),
            'add_time' => time(),
            'unit' => $unit,
            'station_id' => intval($station_id),
            'sort' => intval($sort),
            'brand_id' => intval($brand_id)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_product_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_product_list .= '`'.$column_str.'`';

            if(strpos($get_product_list, '`'.$this->primary_key.'`') === false) {
                $get_product_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_product_list .= '*';
        }

        $get_product_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_product_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_product_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->product_sn = isset($row['product_sn']) ? $row['product_sn'] : null;
            $this->price = isset($row['price']) ? $row['price'] : 0;
            $this->name = isset($row['name']) ? $row['name'] : null;
            $this->status = isset($row['status']) ? $row['status'] : 0;
            $this->category_id = isset($row['category_id']) ? $row['category_id'] : 0;
            $this->image = isset($row['image']) ? $row['image'] : null;
            $this->thumb = isset($row['thumb']) ? $row['thumb'] : null;
            $this->market_price = isset($row['market_price']) ? $row['market_price'] : 0;
            $this->group_limit = isset($row['group_limit']) ? $row['group_limit'] : 0;
            $this->group_price = isset($row['group_price']) ? $row['group_price'] : 0;
            $this->detail = isset($row['detail']) ? $row['detail'] : null;
            $this->desc = isset($row['desc']) ? $row['desc'] : null;
            $this->add_time = isset($row['add_time']) ? $row['add_time'] : null;
            $this->unit = isset($row['unit']) ? $row['unit'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;
            $this->sort = isset($row['sort']) ? $row['sort'] : null;
            $this->brand_id = isset($row['brand_id']) ? $row['brand_id'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('product').' (
            `id` bigint not null auto_increment unique,
            `station_id` bigint not null comment \'站点ID\',
            `product_sn` varchar(255) not null primary key comment \'商品编号\',
            `name` varchar(255) not null comment \'商品名称\',
            `category_id` bigint not null comment \'商品分类ID\',
            `price` decimal(18,2) not null comment \'单独购价格\',
            `market_price` decimal(18,2) not null default \'0\' comment \'市场价格\',
            `group_price` decimal(18,2) not null comment \'团购价格\',
            `group_limit` int not null comment \'团购人数\',
            `image` varchar(255) not null comment \'商品主图URL\',
            `thumb` varchar(255) not null comment \'商品缩略图\',
            `status` tinyint(1) not null default \'1\' comment \'商品状态\',
            `detail` text comment \'商品详情\',
            `desc` text comment \'商品摘要\',
            `add_time` int not null comment \'添加时间\',
            `unit` varchar(255) not null comment \'单位\',
            `sort` int not null default \'50\' comment \'排序\',
            `brand_id` int not null default \'0\' comment \'产品品牌\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function generate_sn() {
        $begin = 1;
        $max = pow(10, PRODUCT_SN_LENGTH);
        $step = $max/4 < 1000 ? intval($max/4) : 999;
        $product_sn = '';

        do {
            $end = $begin + $step;
            $sn_arr = range($begin, $end);
            $begin = $end++;

            $sn = array_shift($sn_arr);
            $cnt = PRODUCT_SN_LENGTH;
            $cnt = $cnt - strlen($sn);
            while($cnt >= 1) {
                $sn = '0'.$sn;
                $cnt--;
            }

            $check_product_sn = 'select `product_sn` from '.$this->db->table($this->__name).' where `product_sn`=\''.PRODUCT_SN_PRE.$sn.'\'';

            if(!$this->db->fetch_one($check_product_sn)) {
                $product_sn = PRODUCT_SN_PRE.$sn;
                break;
            }
        } while($end <= $max);

        return $product_sn;
    }

    public function __toString() {
        $echo_format = '{ id:%d, price:%.2f, name:%s, product_sn:%s, status:%d,  category_id:%d,
                          market_price:%.2f, group_price:%.2f, group_limit:%.2f, image:%s, thumb:%s,
                          unit:%s, detail:%s, desc:%s, add_time:%s, station_id:%d, sort:%d }';

        return sprintf($echo_format, $this->id, $this->price, $this->name, $this->product_sn, $this->status,
                       $this->category_id, $this->market_price, $this->group_price, $this->group_limit, $this->image,
                       $this->thumb, $this->unit, $this->detail, $this->desc, $this->add_time, $this->station_id, $this->sort);
    }
}