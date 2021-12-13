<?php
/*-----------------------------------------数据库对象查询封装-------------------------------*/
class ActiveRecordAction extends YouYaX
{
    public $table;
    public $data;
    public $obj;
    function __construct($table)
    {
        parent::__construct();
        $this->table = $table;
        $this->data  = array();
        $this->obj   = new stdClass();
    }
    function __set($name, $value)
    {
        $this->data[$name] = $value;
        if (is_object($this->obj)) {
            $this->obj->$name = $value;
        }
    }
    function __get($name)
    {
        if (is_object($this->obj)) {
            return $this->obj->$name;
        }
    }
    function __isset($name)
    {
        return isset($this->obj->$name);
    }
    public function aradd()
    {
        $sql = "insert into " . $this->table . "(" . implode(",", array_keys($this->data)) . ") values('" . implode("','", array_values($this->data)) . "')";
        $this->db->exec($sql);
    }
    public function arfind($id)
    {
        $data = $this->db->query("select * from $this->table where id=" . $id);
        $num  = $this->db->query("select count(*) from $this->table where id=" . $id)->fetchColumn();
        if ($num) {
            $this->obj = $data->fetch(PDO::FETCH_OBJ);
            return true;
        } else {
            return false;
        }
    }
    public function arselect($param = '')
    {
        $array = array();
        if ($param == '') {
            $sql = "select * from $this->table";
            foreach ($this->db->query($sql) as $arr) {
                $array[] = $arr;
            }
            return $array;
        } else {
            $data = split(",", $param);
            foreach ($data as $v) {
                $res = $this->db->query("select * from $this->table where id=" . $v);
                $num = $this->db->query("select count(*) from $this->table where id=" . $v)->fetchColumn();
                if ($num) {
                    $arr     = $res->fetch();
                    $array[] = $arr;
                }
            }
            return $array;
        }
    }
    public function arsave()
    {
        foreach ($this->obj as $k => $v) {
            $sql = "update " . $this->table . " set " . $k . "='" . $v . "' where id=" . $this->obj->id;
            $this->db->exec($sql);
        }
    }
    public function ardelete()
    {
        foreach ($this->obj as $k => $v) {
            $sql = "delete from " . $this->table . " where id=" . $this->obj->id;
            $this->db->exec($sql);
        }
    }
}
/*-----------------------------------------数据库对象查询封装 end-------------------------------*/
?>