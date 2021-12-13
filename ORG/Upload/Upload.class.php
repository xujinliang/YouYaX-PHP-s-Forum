<?php
class Upload
{
    public $size = '';
    public $type = '';
    public $path = '';
    public function __construct()
    {
        $this->type = array();
        $this->type2 = array('jpg','jpeg','gif','png');
    }
    public function upload_limit()
    {
        $hz = substr(strstr($_FILES["file"]["name"],"."),1);  
        if (in_array($_FILES["file"]["type"], $this->type) && in_array(strtolower($hz),$this->type2) && ($_FILES["file"]["size"] < $this->size)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
            } else {
                echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                echo "Type: " . $_FILES["file"]["type"] . "<br />";
                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
                if (!file_exists($this->path)) {
                    mkdir($this->path);
                }
                if (file_exists($this->path . "/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $this->path . "/" . $_FILES["file"]["name"]);
                    echo "Stored in: " . $this->path . "/" . $_FILES["file"]["name"];
                }
            }
        } else {
            echo "Invalid file";
        }
    }
    public function upload()
    {
        if (isset($_FILES["file"]["tmp_name"])) {
            if (!file_exists($this->path)) {
                mkdir($this->path);
            }
            $filename = $_FILES["file"]["name"];
            if (file_exists($this->path . "/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $this->path . "/" . $filename)) {
                    echo "upload success!";
                } else {
                    echo "upload fail!";
                }
            }
        }
    }
}
?>