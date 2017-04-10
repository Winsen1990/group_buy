<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class GalleryDAO extends BaseDAO {
    public $id;
    public $product_sn;
    public $image;
    public $sort;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = $this->db->table('gallery');
        $this->primary_key = 'id';
    }

    public function delete($condition) {
        $delete_gallery = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_gallery .= ' where '.$condition;
        }

        return $this->db->delete($delete_gallery);
    }

    public function save() {
        $data = array(
            'product_sn' => $this->product_sn,
            'sort' => $this->sort,
            'image' => $this->image
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($product_sn, $image, $station_id, $sort = 50) {
        $data = array(
            'product_sn' => $this->db->escape($product_sn),
            'image' => $this->db->escape($image),
            'sort' => intval($sort),
            'station_id' => intval($station_id)
        );

        return $this->db->auto_insert($this->__name, array($data));
    }

    public function get_list($where_condition, $columns = array()) {
        $get_gallery_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_gallery_list .= '`'.$column_str.'`';

            if(strpos($get_gallery_list, '`'.$this->primary_key.'`') === false) {
                $get_gallery_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_gallery_list .= '*';
        }

        $get_gallery_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_gallery_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_gallery_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->product_sn = isset($row['product_sn']) ? $row['product_sn'] : null;
            $this->image = isset($row['image']) ? $row['image'] : null;
            $this->sort = isset($row['sort']) ? $row['sort'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('gallery').' (
            `id` bigint not null auto_increment primary key,
            `station_id` bigint not null comment \'站点ID\',
            `product_sn` varchar(255) not null comment \'商品编号\',
            `image` varchar(255) not null comment \'图片URL\',
            `sort` int not null default \'10\' comment \'图片排序\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, image:%s, sort:%d, product_sn:%s, station_id:%d }';

        return sprintf($echo_format, $this->id, $this->image, $this->sort, $this->product_sn, $this->station_id);
    }
}