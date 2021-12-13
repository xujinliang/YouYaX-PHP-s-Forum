<?php
session_start();
Header("Content-type: image/png");
require('../ORG/Code/Code.class.php');
$code=new Code(6);
$code->build();
?>