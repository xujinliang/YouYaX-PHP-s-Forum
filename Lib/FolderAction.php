<?php
class FolderAction extends YouYaX
{
    public function judge()
    {
        $mix = require("./Conf/mix.config.php");
        if($mix['list_fold']){
        		echo 'close';
        }else{
        		echo 'open';
        }
    }
}
?>