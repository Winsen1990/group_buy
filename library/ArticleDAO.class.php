<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/9/14
 * Time: 下午6:34
 */
class ArticleDAO extends BaseDAO {
    public $id;
    public $title;
    public $section_id;
    public $desc;
    public $keywords;
    public $author;
    public $sort;
    public $station_id;
    public $cover;
    public $thumb;
    public $content;
    public $wap_content;
    public $status;
    public $add_time;
    public $last_modify;
    public $view_count;
    public $thumbs_up;
    public $thumbs_down;
    protected $primary_key;
    protected $res;

    public function __construct() {
        parent::__construct();
        $this->__name = 'article';
        $this->primary_key = 'id';
    }

    public function delete($condition) {
        $delete_article = 'delete from '.$this->db->table($this->__name);

        if($condition) {
            $delete_article .= ' where '.$condition;
        }

        return $this->db->delete($delete_article);
    }

    public function save() {
        $data = array(
            'title' => $this->title,
            'section_id' => $this->section_id,
            'sort' => $this->sort,
            'desc' => $this->desc,
            'keywords' => $this->keywords,
            'author' => $this->author,
            'thumb' => $this->thumb,
            'cover' => $this->cover,
            'content' => $this->content,
            'wap_content' => $this->wap_content,
            'status' => $this->status
        );

        return $this->db->auto_update($this->__name, $data, '`'.$this->primary_key.'`='.$this->{$this->primary_key});
    }

    public function add($title, $section_id, $desc, $keywords, $author, $content, $wap_content, $status = 1, $station_id, $cover = '', $thumb = '', $sort = 50) {
        $data = array(
            'title' => $this->db->escape($title),
            'section_id' => intval($section_id),
            'sort' => intval($sort),
            'status' => intval($status),
            'station_id' => intval($station_id),
            'cover' => $this->db->escape($cover),
            'thumb' => $this->db->escape($thumb),
            'desc' => $this->db->escape($desc),
            'keywords' => $this->db->escape($keywords),
            'author' => $this->db->escape($author),
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
            $this->title = isset($row['title']) ? $row['title'] : null;
            $this->section_id = isset($row['section_id']) ? $row['section_id'] : 0;
            $this->sort = isset($row['sort']) ? $row['sort'] : null;
            $this->author = isset($row['author']) ? $row['author'] : null;
            $this->keywords = isset($row['keywords']) ? $row['keywords'] : null;
            $this->content = isset($row['content']) ? $row['content'] : null;
            $this->wap_content = isset($row['wap_content']) ? $row['wap_content'] : null;
            $this->station_id = isset($row['station_id']) ? $row['station_id'] : null;
            $this->cover = isset($row['cover']) ? $row['cover'] : null;
            $this->thumb = isset($row['thumb']) ? $row['thumb'] : null;
            $this->add_time = isset($row['add_time']) ? $row['add_time'] : null;
            $this->last_modify = isset($row['last_modify']) ? $row['last_modify'] : null;
            $this->view_count = isset($row['view_count']) ? $row['view_count'] : null;
            $this->thumbs_up = isset($row['thumbs_up']) ? $row['thumbs_up'] : null;
            $this->thumbs_down = isset($row['thumbs_down']) ? $row['thumbs_down'] : null;
            $this->status = isset($row['status']) ? $row['status'] : null;

            return true;
        } else {
            return false;
        }
    }

    public function init() {
        $create_table = 'create table if not exists '.$this->db->table($this->__name).' (
            `id` bigint not null auto_increment primary key,
            `station_id` bigint not null comment \'站点ID\',
            `title` varchar(255) not null comment \'资讯标题\',
            `section_id` bigint not null default \'0\' comment \'栏目ID\',
            `author` varchar(255) comment \'作者\',
            `keywords` varchar(255) comment \'资讯关键词\',
            `desc` varchar(255) comment \'资讯简介\',
            `content` text comment \'资讯内容\',
            `wap_content` text comment \'手机资讯内容\',
            `cover` varchar(255) comment \'封面图片\',
            `thumb` varchar(255) comment \'缩略图\',
            `sort` int not null default \'50\' comment \'排序\',
            `status` int not null default \'1\' comment \'状态\',
            `add_time` int not null comment \'创建时间\',
            `last_modify` timestamp not null comment \'修改时间\',
            `view_count` int not null default \'0\' comment \'浏览次数\',
            `thumbs_up` int not null default \'0\' comment \'赞\',
            `thumbs_down` int not null default \'0\' comment \'踩\'
        ) engine=InnoDB,default charset='.DB_CHARSET.';';

        return $this->db->query($create_table);
    }

    public function __toString() {
        $echo_format = '{ id:%d, title:%s, sort:%d, section_id:%d, author:%s, station_id:%d, cover:%s, thumb:%s }';

        return sprintf($echo_format, $this->id, $this->title, $this->sort, $this->section_id, $this->author, $this->station_id,
                       $this->cover, $this->thumb);
    }
}