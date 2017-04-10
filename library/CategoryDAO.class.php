<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class CategoryDAO extends BaseDAO {
    public $id;
    public $name;
    public $parent_id;
    public $path;
    public $sort;
    public $station_id;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = 'category';
        $this->primary_key = 'id';
    }

    public function delete($condition) {
        $delete_gallery = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_gallery .= ' where '.$condition;
        }

        return $this->db->delete($delete_gallery);
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

    public function save() {
        $this->path = $this->{$this->primary_key}.',';

        if($this->parent_id > 0) {
            $get_parent_path = 'select `path` from ' . $this->db->table($this->__name) . ' where `id`=' . $this->parent_id;
            $parent_path = $this->db->fetch_one($get_parent_path);

            if($parent_path) {
                $this->path = $parent_path.$this->path;
            }
        }

        $data = array(
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'sort' => $this->sort,
            'path' => $this->path
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($name, $station_id, $parent_id = 0, $sort = 50) {
        $data = array(
            'name' => $this->db->escape($name),
            'parent_id' => intval($parent_id),
            'sort' => intval($sort),
            'station_id' => intval($station_id)
        );

        if($this->db->auto_insert($this->__name, array($data))) {
            $id = $this->db->get_last_id();
            $path = $id.',';

            if($parent_id > 0) {
                $get_parent_path = 'select `path` from ' . $this->db->table($this->__name) . ' where `'.$this->primary_key.'`=' . intval($parent_id);
                $parent_path = $this->db->fetch_one($get_parent_path);

                if($parent_path) {
                    $path = $parent_path.$path;
                }
            }

            $data = array(
                'path' => $path
            );

            $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$id);

            return true;
        }

        return false;
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
            $this->name = isset($row['name']) ? $row['name'] : null;
            $this->parent_id = isset($row['parent_id']) ? $row['parent_id'] : 0;
            $this->sort = isset($row['sort']) ? $row['sort'] : null;
            $this->path = isset($row['path']) ? $row['path'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table('category').' (
            `id` bigint not null auto_increment primary key,
            `station_id` bigint not null comment \'站点ID\',
            `name` varchar(255) not null comment \'商品分类名\',
            `parent_id` bigint not null default \'0\' comment \'上级分类ID\',
            `path` varchar(255) comment \'分类路径\',
            `sort` int not null default \'50\' comment \'排序\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, name:%s, sort:%d, parent_id:%d, path:%s, station_id:%d }';

        return sprintf($echo_format, $this->id, $this->name, $this->sort, $this->parent_id, $this->path, $this->station_id);
    }
}