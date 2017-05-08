<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class BrandDAO extends BaseDAO {
    public $id;
    public $name;
    public $desc;
    public $keywords;
    public $sort;
    public $station_id;
    public $logo;
    public $content;
    public $wap_content;
    public $status;
    public $add_time;
    public $last_modify;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = 'brand';
        $this->primary_key = 'id';
    }

    public function delete($condition) {
        $delete_brand = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_brand .= ' where '.$condition;
        }

        return $this->db->delete($delete_brand);
    }

    public function save() {
        $data = array(
            'name' => $this->name,
            'sort' => $this->sort,
            'desc' => $this->desc,
            'keywords' => $this->keywords,
            'logo' => $this->logo,
            'content' => $this->content,
            'wap_content' => $this->wap_content,
            'status' => $this->status
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($name, $desc, $keywords, $content, $wap_content, $status = 1, $station_id, $logo = '', $sort = 50) {
        $data = array(
            'name' => $this->db->escape($name),
            'sort' => intval($sort),
            'status' => intval($status),
            'station_id' => intval($station_id),
            'logo' => $this->db->escape($logo),
            'desc' => $this->db->escape($desc),
            'keywords' => $this->db->escape($keywords),
            'content' => $this->db->escape($content),
            'wap_content' => $this->db->escape($wap_content),
            'add_time' => time(),
            'last_modify' => date('Y-m-d H:i:s'),
        );

        if($this->db->auto_insert($this->__name, array($data))) {
            return true;
        }

        return false;
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

    public function get_list($where_condition, $columns = array()) {
        $get_section_list = 'select ';

        if(is_array($columns) && count($columns)) {
            $column_str = implode('`,`', $columns);
            $get_section_list .= '`'.$column_str.'`';

            if(strpos($get_section_list, '`'.$this->primary_key.'`') === false) {
                $get_section_list .= '`'.$this->primary_key.'`';
            }
        } else {
            $get_section_list .= '*';
        }

        $get_section_list .= ' from '.$this->db->table($this->__name);
        if($where_condition) {
            $get_section_list .= ' where 1 and ' . $where_condition;
        }

        $this->res = $this->db->query($get_section_list);

        return $this->next();
    }

    public function get_count() {
        return $this->res->num_rows;
    }

    public function next() {
        if($this->res && $row = mysqli_fetch_assoc($this->res)) {
            $this->id = isset($row['id']) ? $row['id'] : null;
            $this->name = isset($row['name']) ? $row['name'] : null;
            $this->sort = isset($row['sort']) ? $row['sort'] : null;
            $this->keywords = isset($row['keywords']) ? $row['keywords'] : null;
            $this->content = isset($row['content']) ? $row['content'] : null;
            $this->wap_content = isset($row['wap_content']) ? $row['wap_content'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;
            $this->logo = isset($row['logo']) ? $row['logo'] : null;
            $this->add_time = isset($row['add_time']) ? $row['add_time'] : null;
            $this->last_modify = isset($row['last_modify']) ? $row['last_modify'] : null;
            $this->status = isset($row['status']) ? $row['status'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table($this->__name).' (
            `id` bigint not null auto_increment primary key,
            `name` varchar(255) not null comment \'品牌名称\',
            `station_id` bigint(20) NOT NULL COMMENT \'站点ID\',
            `keywords` varchar(255) COMMENT \'品牌关键词\',
            `desc` varchar(255) COMMENT \'品牌简介\',
            `content` text COMMENT \'品牌详细介绍\',
            `wap_content` text COMMENT \'手机品牌详细介绍\',
            `logo` varchar(255) COMMENT \'品牌LOGO\',
            `sort` int(11) NOT NULL DEFAULT \'50\' COMMENT \'排序\',
            `status` int(11) NOT NULL DEFAULT \'1\' COMMENT \'状态\',
            `add_time` int(11) NOT NULL COMMENT \'创建时间\',
            `last_modify` timestamp NOT NULL COMMENT \'修改时间\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, name:%s, sort:%d, station_id:%d, logo:%s }';

        return sprintf($echo_format, $this->id, $this->name, $this->sort, $this->station_id,
                       $this->logo);
    }
}