******************************注意事项*******************************

【注意：当您安装成功后，为了您的系统安全，请删除"install"文件夹】

在当前默认系统下，系统设置了未登录用户缓存，缓存时间为60秒，对登录用户无影响。

分别位于IndexAction.php(首页) 、ListAction.php(列表页) 和 ContentAction.php(内容页)中的index方法中，具体位置位于方法开头和结尾。

具体写法

if(empty($_SESSION['youyax_user']) && ……){
  $cache = new CacheAction(60);
}
表示当未登录用户访问论坛时，访问的是前60秒缓存的页面，调用的是缓存页面，60秒后自动更新。

if(empty($_SESSION['youyax_user']) && ……){
  $cache->endCache();
}
表示将输出内容缓存到文件中。

有问题可以联系作者，亦可以去官网论坛反馈：http://www.youyax.com/forum