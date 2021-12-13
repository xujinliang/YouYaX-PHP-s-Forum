<?php
class Code
{
    public $num;
    public function __construct($param = '')
    {
        if ($param == '' || $param == null)
            $param = 4;
        $this->num = $param;
    }
    public function build()
    {
        $n    = (50 / 4) * $this->num;
        $im   = imagecreate($n, 24); //新建一个基于调色板的图像,返回一个图像标识符
        $gray = imagecolorallocate($im, 200, 200, 200); //为一幅图像分配颜色
        imagefill($im, 0, 0, $gray); //区域填充
        $_SESSION["verify"] = "";
        for ($i = 0; $i < $this->num; $i++) {
            $str      = mt_rand(3, 6); //生成3-6的随机数
            $size     = mt_rand(10, 14);
            $validate = mt_rand(0, 9);
            
            $_SESSION["verify"] .= $validate; //注意是点号
            
            imagestring($im, $size, (5 + $i * 10), $str, $validate, imagecolorallocate($im, rand(0, 130), rand(0, 130), rand(0, 130))); //水平地画一行字符串
        }
        for ($i = 0; $i < 200; $i++) {
            $randcolor = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($im, rand() % 70, rand() % 30, $randcolor); //画一个单一像素
        }
        imagepng($im); // 以 PNG 格式将图像输出到浏览器或文件
        imagedestroy($im); //销毁一图像
    }
}
?>
