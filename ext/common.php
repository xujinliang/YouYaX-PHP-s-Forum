<?php
function my_sort($a, $b){
  if ($a == $b) return 0;
  return ($a > $b) ? -1 : 1;
}
function setdate($param){
    return date('Y-m-d H:i:s', $param);
}
function filter_function($param){
		$filters=require("Conf/filter.config.php");
		return strtr($param,$filters);
}
function array_sort($arr, $field, $by = SORT_ASC){
    foreach ($arr as $v) {
        $r[] = $v[$field];
    }
    array_multisort($r, $by, $arr);
    return $arr;
}
function directory_size($directory)
{
    $dir_size = 0;
    if ($dir_handle = @opendir($directory)) {
        while ($filename = readdir($dir_handle)) {
            if ($filename != "." && $filename != "..") {
                $subFile = $directory . "/" . $filename;
                if (is_dir($subFile))
                    $dir_size += directory_size($subFile);
                if (is_file($subFile))
                    $dir_size += filesize($subFile);
            }
        }
        closedir($dir_handle);
        return $dir_size;
    }
}
?>