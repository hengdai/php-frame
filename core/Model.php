<?php
/**
 * Created by PhpStorm.
 * User: daiheng
 * Date: 2017/6/8
 * Time: 19:13
 */

class Model
{
    protected $_dbHandel;
    protected $result;
    protected $_table;
    protected $_pk;
    private $filter = '';
    //数据库操作方法列表
    protected $methods = [];
    //进行字段赋值的时候的字段
    protected $data = [];

    protected static $config = [];
    public static $dbConfig = [];
    private static $instance = null;
    private static $pdoInstance = null;

    function __construct()
    {
        self::$config = require(APP_PATH . 'config/config.php');
        self::$dbConfig = self::$config['db'];
        $this->_dbHandel = self::getInstance();
        $_model = lcfirst(substr(get_class($this), 0, -5));
        $this->_table = $this->getTableName($_model);

        return $this;
    }

    public function init($pk)
    {
        $this->_pk = $pk;
    }

    public function initSelect()
    {
        $this->filter = 'select * from '.$this->_table . ' where 1=1';
    }

    public static function getInstance()
    {
        if (!is_null(self::$instance)) {
            return self::$instance;
        }

        $conn = new mysqli(self::$dbConfig['DB_HOST'], self::$dbConfig['DB_USER'], self::$dbConfig['DB_PWD'], self::$dbConfig['DB_NAME']);

        if ($conn->connect_error) {
            exit('数据库连接失败！');
        }
        $conn->query("SET NAMES 'utf-8'");

        self::$instance = $conn;
        return self::$instance;
    }

    public static function getPdoInstance()
    {
        if (!is_null(self::$pdoInstance)) {
            return self::$pdoInstance;
        }

        $conn = new PDO('mysql:host=' . self::$dbConfig['DB_HOST'] . ';dbname=' . self::$dbConfig['DB_NAME'], self::$dbConfig['DB_USER'], self::$dbConfig['DB_PWD']);

        if (!$conn) {
            exit('数据库连接失败！');
        }
        $conn->query("SET NAMES 'utf-8'");

        self::$pdoInstance = $conn;
        return self::$pdoInstance;
    }

    public function getTableName($hump)
    {
        $result = [];
        for ($i = 0; $i < strlen($hump); $i++) {
            if ($hump[$i] == strtolower($hump[$i])) {
                $result[] = $hump[$i];
            } else {
                $result[] = '_';
                $result[] = strtolower($hump[$i]);
            }
        }

        $str = implode('', $result);
        return $str;
    }

    public function eq($params = [])
    {
        if (!empty($params)) {
            $this->filter .= ' and ';
            $this->filter .= implode('=', $params);
        }

        return $this;
    }

    public function neq($params = [])
    {
        if (!empty($params)) {
            $this->filter .= ' and ';
            $this->filter .= implode('!=', $params);
        }

        return $this;
    }

    public function lte($params = [])
    {
        if (!empty($params)) {
            $this->filter .= ' and ';
            $this->filter .= implode('<=', $params);
        }

        return $this;
    }

    public function gte($params = [])
    {
        if (!empty($params)) {
            $this->filter .= ' and ';
            $this->filter .= implode('>=', $params);
        }

        return $this;
    }

    public function limit($params)
    {
        if (!empty($params)) {
            $this->filter .= ' limit ';

            if (is_array($params)) {
                $this->filter .= implode(',', $params);
            } else {
                $this->filter .= $params;
            }
        }

        return $this;
    }

    public function find()
    {
        $result = [];

        if (empty($this->filter)) {
            $this->filter = 'select * from '.$this->_table;
        }

        $temp = $this->_dbHandel->query($this->filter);

        while ($info = $temp->fetch_assoc()) {
            $result[] = $info;
        }

        return $result;
    }

    public function findFirst()
    {
        if (empty($this->filter)) {
            $this->filter = 'select * from ' . $this->_table;
        }

        $this->filter .= ' limit 1';
        $temp = $this->_dbHandel->query($this->filter);

        return $temp->fetch_object();
    }

    public function findByPk($params)
    {
        if (empty($this->filter)) {
            $this->filter = 'select * from '.$this->_table.' where ';
        }

        $this->filter .= ' and ' . $this->_pk . ' = '. $params;
        $temp = $this->_dbHandel->query($this->filter);

        if (empty($temp)) {
            return false;
        }

        $object = new ZphUserModel();

        foreach ($temp->fetch_assoc() as $key => $value) {
            $object->$key = $value;
        }

        return $object;
    }

    //以下开始实现ActiveRecord
    //对字段进行赋值
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    //使用isset判断对象是都有该属性的时候
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    //AR模式的修改数据库数据
    public function save()
    {
        try {
            if (empty($this->data)) {
                return false;
            }

            $data = $this->data;
            $pk = $this->_pk;

            //如果没有设置pk说明是新增数据
            if (!isset($data[$pk])) {
                $fildString = '';
                $dataString = '';
                $length = count($data);
                $i = 1;
                foreach ($data as $key => $value) {
                    $i++;
                    $fildString .= $key . (($i > $length) ? '' : ', ');
                    $dataString .= $value . (($i > $length) ? '' : ', ');
                }

                $this->filter .= 'insert into ' . $this->_table . '(' . $fildString . ') values (' . $dataString . ')';
            } else {
                $primaryKeyValue = $data[$pk];
                unset($data[$pk]);
                $length = count($data);
                $i = 1;
                $Dstring = '';
                foreach ($data as $key => $value) {
                    $i++;
                    $Dstring .= $key . '="' . $value . (($i > $length) ? '"' : '", ');
                }
                $this->filter .= 'update ' . $this->_table . ' set ' . $Dstring . ' where ' . $pk . ' = ' . $primaryKeyValue;
            }
        } catch (Exception $e) {
            throw new Exception('', [$e]);
        }

       return $this->_dbHandel->query($this->filter);
    }
}