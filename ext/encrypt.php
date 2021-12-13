<?php
function cc_encrypt($txtStream)
{
    $key       = include(dirname(__FILE__)."./../Conf/key.config.php");
    //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
    $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
    //随机找一个数字，并从密锁串中找到一个密锁值
    $lockLen = strlen($lockstream);
    $lockCount = rand(0,$lockLen-1);
    $randomLock = $lockstream[$lockCount];
    //结合随机密锁值生成MD5后的密码
    $password = md5($key.$randomLock);
    //开始对字符串加密
    $txtStream = base64_encode($txtStream);
    $tmpStream = '';
    $i=0;$j=0;$k = 0;
    for ($i=0; $i<strlen($txtStream); $i++) {
    $k = ($k == strlen($password)) ? 0 : $k;
    $j = (strpos($lockstream,$txtStream[$i])+$lockCount+ord($password[$k]))%($lockLen);
    $tmpStream .= $lockstream[$j];
    $k++;
    }
    return $tmpStream.$randomLock;
}
?>