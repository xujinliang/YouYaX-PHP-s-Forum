<?php
function cc_encrypt($txtStream)
{
    $key       = include(dirname(__FILE__)."./../Conf/key.config.php");
    //�����������ܳ����ظ��ַ�������A-Z,a-z,0-9,/,=,+,_,
    $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
    //�����һ�����֣��������������ҵ�һ������ֵ
    $lockLen = strlen($lockstream);
    $lockCount = rand(0,$lockLen-1);
    $randomLock = $lockstream[$lockCount];
    //����������ֵ����MD5�������
    $password = md5($key.$randomLock);
    //��ʼ���ַ�������
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