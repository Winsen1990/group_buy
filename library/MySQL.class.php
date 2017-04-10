<?php
/**
 * MySQL数据库服务
 * @author winsen
 * @version 1.1.1
 * @date 2015-7-8
 */
class MySQL
{
    protected $host;
    protected $username;
    protected $password;
    protected $db_name;
    protected $conn;
    protected $charset = 'utf8';
    protected $error;
    protected $errno;
    protected $prefix;
    private static $self;

    /**
     * 构造函数
     * @param string $host 数据库服务器地址
     * @param string $username 数据库用户名
     * @param string $password 数据库密码
     * @param string $db_name 数据库名
     * @param string $prefix
     * @param string $charset 数据库链接时采用的编码,默认为utf-8
     * @return mixed
     * @author winsen
     */
    private function __construct($host, $username, $password, $db_name, $prefix, $charset = 'utf8')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;
        $this->charset = $charset;
        $this->perfix = $prefix;

        $this->conn = mysqli_connect($host, $username, $password, $db_name);

        if($this->conn)
        {
            mysqli_set_charset($this->conn, $this->charset);
        } else {
            echo 'Can\'t connect to database.';
            $this->error = mysqli_error($this->conn);
            $this->errno = mysqli_errno($this->conn);
            exit;
        }
    }

    /**
     * 单例模式
     * @param $host
     * @param $username
     * @param $password
     * @param $db_name
     * @param $prefix
     * @param string $charset
     * @return MySQL
     */
    public static function get_instance($host = DB_HOST, $username = DB_USERNAME, $password = DB_PASSWORD, $db_name = DB_DBNAME, $prefix = DB_PREFIX, $charset = DB_CHARSET) {
        if(self::$self != null) {
            return self::$self;
        }

        self::$self = new MySQL($host, $username, $password, $db_name, $prefix, $charset);

        return self::$self;
    }

    /**
     * 返回带前缀的表名
     * @param string $table_name
     * @return string
     * @author winsen
     */
    public function table($table_name)
    {
        if($table_name == '') return '';

        return '`'.$this->perfix.$table_name.'`';
    }

    /**
     * 判断当前数据库链接是否有效
     * @return void
     * @author winsen
     */
    public function validate()
    {
        if(!$this->conn)
        {
            echo 'Plz connect to database first.';
            exit;
        }
    }

    /**
     * 返回最后一次插入的自增值
     * @return int 成功返回last_id,失败时返回false
     * @author winsen
     */
    public function get_last_id()
    {
        return mysqli_insert_id($this->conn);
    }

    public function get_affect_rows()
    {
        return mysqli_affected_rows($this->conn);
    }

    /**
     * 过滤掉会引发mysql安全问题的变量
     * @param string $var 需要过滤的变量
     * @return string 过滤后的安全变量
     * @author winsen
     */
    public function escape($var)
    {
        return mysqli_real_escape_string($this->conn, $var);
    }

    /**
     * 以多维数组的形式返回sql语句的查询结果集
     * @param string $sql 需要执行的sql语句
     * @return mixed 成功时返回array,失败时返回null
     * @author winsen
     */
    public function fetch_all($sql)
    {
        $this->validate();

        $result = mysqli_query($this->conn, $sql);
        $response = array();

        if(!$result)
        {
            return null;
        }

        while($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        if(count($response) > 0)
        {
            return $response;
        } else {
            return null;
        }
    }

    /**
     * 以数组的形式返回sql语句的查询结果集
     * @param string $sql 需要执行的sql语句
     * @return mixed 成功时返回array,失败时返回null
     * @author winsen
     */
    public function fetch_row($sql)
    {
        $this->validate();

        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            return null;
        }

        if($row = mysqli_fetch_assoc($result))
        {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * 提交sql语句直接执行,无需返回结果
     * @param string $sql 需要执行的sql语句
     * @return resource 成功时返回resource对象,失败时返回false
     * @author winsen
     */
    public function query($sql)
    {
        $this->validate();

        return mysqli_query($this->conn, $sql);
    }

    /**
     * 提交sql语句执行插入操作
     * @param string $sql 需要执行的sql语句
     * @return resource 成功时返回resource对象,失败时返回false
     * @author winsen
     */
    public function insert($sql)
    {
        return $this->query($sql);
    }

    /**
     * 提交sql语句执行删除操作
     * @param string $sql 需要执行的sql语句
     * @return resource 成功时返回resource对象,失败时返回false
     * @author winsen
     */
    public function delete($sql)
    {
        return $this->query($sql);
    }

    /**
     * 提交sql语句执行更新操作
     * @param string $sql 需要执行的sql语句
     * @return resource 成功时返回resource对象,失败时返回false
     * @author winsen
     */
    public function update($sql)
    {
        return $this->query($sql);
    }

    /**
     * 提交sql语句查询第一个值
     * @param string $sql 需要执行的sql语句
     * @return mixed 成功时返回相应的值，失败时返回false
     * @author winsen
     */
    public function fetch_one($sql)
    {
        $this->validate();

        $result = mysqli_query($this->conn, $sql);
        if(!$result)
        {
            return null;
        }

        if($row = mysqli_fetch_row($result))
        {
            return $row[0];
        } else {
            return null;
        }
    }

    public function errmsg()
    {
        return mysqli_error($this->conn);
    }

    /**
     * 开始事务
     */
    public function begin()
    {
        $this->query('begin;');
    }

    /**
     * 回滚事务
     */
    public function rollback()
    {
        $this->query('rollback;');
    }

    /**
     * 提交并结束事务
     */
    public function commit()
    {
        $this->query('commit;');
    }

    /**
     * 自动插入
     */
    public function auto_insert($table, $data)
    {
        global $log;
        $sql = 'insert into '.$this->table($table).' (%s) values %s';

        $columns = '';
        $values = '';
        foreach($data as $i=>$d)
        {
            if($i == 0)
            {
                $columns = '`'.implode('`,`', array_keys($d)).'`';
            }
            $values .= '(\''.implode('\',\'', $d).'\'),';
        }

        $values = substr($values, 0, strlen($values)-1);

        $sql = sprintf($sql, $columns, $values);

        $log->record($sql);
        return $this->insert($sql);
    }

    /**
     * 自动更新
     */
    public function auto_update($table, $data, $where = 1, $order = '', $limit = '')
    {
        global $log;

        $update = '';
        $expression_regex = '/^exp\((.*)?\)$/i';
        foreach($data as $key=>$value)
        {
            if(preg_match($expression_regex, $value, $v)) {
                $update .= '`'.$key.'`='.$v[1].',';
            } else {
                $update .= '`' . $key . '`=\'' . $value . '\',';
            }
        }
        $update = substr($update, 0, strlen($update)-1);

        $sql = 'update '.$this->table($table).' set %s where %s %s %s';

        if($order != '')
        {
            $order = ' order by '.$order;
        }

        if($limit != '')
        {
            $limit = ' limit '.$limit;
        }

        $sql = sprintf($sql, $update, $where, $order, $limit);

        $log->record($sql);
        return $this->update($sql);
    }

    /**
     * 自动删除
     */
    public function auto_delete($table, $where)
    {
        global $log;

        $sql = 'delete from '.$this->table($table).' where '.$where;
        $log->record($sql);
        return $this->delete($sql);
    }

    /**
     *
     */
    public function get($table, $conditions = array(), $columns = array(), $order_by = '') {
        global $log;

        $sql = 'select ';

        if(count($columns)) {
            $columns_str = implode('`,', $columns);
            $sql .= '`'.$columns_str.'` ';
        } else {
            $sql .= ' * ';
        }

        $sql .= ' from '.$this->table($table);

        if(count($conditions)) {
            $where_str = ' where 1';

            foreach($conditions as $key=>$value) {
                $explain = explode(' ', $key);

                if($where_str != '') {
                    $where_str .= ' and ';
                }

                if(count($explain) > 1) {
                    //带有操作符
                    $where_str .= '`'.$explain[0].'`'.$explain[1];
                } else {
                    $where_str .= '`'. $key .'`=';
                }

                $explain_value = explode(' ', $value);

                if(count($explain_value) > 1) {
                    //带有操作符
                    $where_str .= $value;
                } else {
                    $where_str .= '\''. $value .'\'';
                }
            }

            $sql .= $where_str;
        }

        if($order_by != '') {
            $sql .= ' order by '.$order_by;
        }

        $sql .= ' limit 1';

        $log->record($sql);

        return $this->fetch_row($sql);
    }

    /**
     *
     */
    public function get_all($table, $conditions = array(), $columns = array(), $order_by = '') {
        global $log;

        $sql = 'select ';

        if(is_array($columns) && count($columns)) {
            $columns_str = implode('`,', $columns);
            $sql .= '`'.$columns_str.'` ';
        } else {
            $sql .= ' * ';
        }

        $sql .= ' from '.$this->table($table);

        if(count($conditions)) {
            $where_str = ' where 1';

            foreach($conditions as $key=>$value) {
                $explain = explode(' ', $key);

                if($where_str != '') {
                    $where_str .= ' and ';
                }

                if(count($explain) > 1) {
                    //带有操作符
                    $where_str .= '`'.$explain[0].'`'.$explain[1];
                } else {
                    $where_str .= '`'. $key .'`=';
                }

                $explain_value = explode(' ', $value);

                if(count($explain_value) > 1) {
                    //带有操作符
                    $where_str .= $value;
                } else {
                    $where_str .= '\''. $value .'\'';
                }
            }

            $sql .= $where_str;
        }

        if($order_by != '') {
            $sql .= ' order by '.$order_by;
        }

        $log->record($sql);

        return $this->fetch_all($sql);
    }

    /**
     * 析构函数,服务器结束操作时关闭数据库链接
     */
    public function __destruct()
    {
        if($this->conn)
        {
            mysqli_close($this->conn);
        }
    }
}
