# 跟着兄弟连学PHP

---

- 错误处理

>1. 错误报告级别 <br>
  通过配置 `php.ini` 文件，修改 `display_roors`的值为 `On`，<br>
  或者直接在脚本中调用 `ini_set()` 函数进行配置

>2. 使用 `trigger_error()` 代替 `die()` 或者 `exit()` <br>
  使程序更有灵活性， 也更容易处理 <br>
  例如 `trigger_error('没有找到文件',E_USER_ERROR)`

>3. 错误日志

- 异常处理

>`try...catch`

- `PHP` 的日期和时间

>1. `time()` <br>
    使用调用此函数，返回一个时间戳

>2. `mktime()` <br>
  具备自动校正日期越界的情况
```
$time=date('Y-m-d',mktime(0,0,0,12,36,2008));
echo $time;     // 2009-01-05
```

>3. `strtotime()` <br>
  将任何英文文本描述的日期解析为 `UNIX` 时间戳

>4. `getdate()` <br>
  返回以 `hours mday minutes mon month seconds wday weekday yday year 0` <br>
  为键的数组

>5. `date()` <br>
  格式化日期

>6. `microtime()` <br>
  微秒


- 文件系统 <br>
  `PHP` 是以 `UNIX` 的文件系统为模型的。


|文件类型|描述|
|---|---|
|`Block`|块设备文件，例如某个磁盘分区、软驱、光驱CD-ROM等|
|`Char`|字符设备，指在`I/O`传输过程中以字符为单位进行传输的设备，例如键盘、打印机等|
|`Dir`|目录类型，目录也是文件的一种，`windows`系统可以获取此种类型|
|`Fifo`|命名管道，常用于将信息从一个进程传递到另一个进程|
|`File`|普通文件类型，例如文本文件和可执行文件等，`windows`系统可以获取此种类型|
|`Link`|符号链接，指向文件指针的指针，类似于快捷方式|
|`UnKnown`|未知类型，`windows`系统可以获取此种类型|

>1. 文件类型判断
```
is_file() : 是否为一个正常的文件
is_dir() : 是否为目录
is_link() : 是否为符号链接
```

>2. 文件属性

|函数名|作用|返回值|
|---|---|---|---|
|`file_exists()`|检查文件或目录是否存在|`true/false`|
|`filesize()`|文件大小|文件大小的字节数，出错返回`false`|
|`is_readable()`|是否可读|如果文件存在并且可读返回`true`，否则返回`false`|
|`is_writable`|是否可写|如果文件存在并且可写返回`true`，否则返回`false`|
|`is_executable`|是否可执行|如果文件存在并且可执行返回`true`，否则返回`false`|
|`filectime()`|文件的创建时间|返回 `UNIX` 时间戳格式|
|`filemtime()`|文件的修改时间|返回 `UNIX` 时间戳格式|
|`fileatime()`|文件的访问时间|返回 `UNIX` 时间戳格式|
|`stat()`|获取文件的大部分属性值|返回给定文件有用的信息数组|

>3. 路径

(1) 操作系统之间的路径差别
|操作系统|示例|
|---|---|
|`UNIX`|`/var/php/www/index.php`|
|`Windows`|支持两种写法：<br>`I. C:\\php\\index.php` <br> `II. C:/php/index.php` <br>考虑到更好的移植性，推荐**第 2 种** |

(2) `basename()` <br>
  获取文件不包括路径的本身名称,在第二个参数指定文件扩展名之后，将不输出扩展名

(3) `dirname()` <br>
  获取文件不包括文件名在内的路径

(4) `pathinfo()` <br>
  获取由文件目录名、基本名以及扩展名组成的数组


>4. 目录操作

(1) 遍历目录
  用到四个函数 : `opendir() readdir  closedir rewinddir`

(2) `glob()` <br>
  搜索指定目录或文件
```
// 搜索名为 index 的目录
print_r(glob('index'));
// 搜索文件名为 index ，扩展名不限的文件
print_r(glob('index.*'))
```

(3) 建立、删除、复制
```
mkdir() : 传入目录名建立目录
rmdir() : 只能删除空目录并且目录必须存在，如果是非空的目录，
          可以先使用 unlink() 删除目录内的文件
copy() : 复制文件，如果需要复制目录及其下所有的文件，则可以先建立目录，
         然后将所有的文件复制进去
```

>5. 文件操作 <br>

(1) `fopen()` <br>
(2) `fwrite()` <br>
  `fputs()` 是此函数别名
  使用 `file_put_contens()` 的效果，和依次调用 `fopen()  fwrite() fclose()` 一样
(3) `fclose()` <br>

(4) 文件读取
|函数|功能|
|---|---|
|`fread()`|读取打开的文件|
|`file_get_contents()`|将文件读入字符串，效率较高|
|`fgets()`|从打开的文件中返回一行|
|`fgetc()`|从打开的文件中返回字符|
|`file()`|把文件读入一个数组中|
|`readfile()`|读取一个文件，并输出到缓冲区|

>5. 移动文件指针 <br>
```
int ftell(resource handle) : 返回文件指针的当前位置
int fseek(resource handle, int offset, [,int whence]) : 移动文件指针到指定的位置
bool rewind(resource handle) : 移动文件指针到文件的开头
```

>6. `flock()` 文件锁定 <br>

>7. 文件的一些基本操作 <br>

|函数|语句结构|描述|
|---|---|---|
|`copy()`|`copy(source, target)`|复制文件|
|`unlink()`|`unlink(file)`|删除文件|
|`ftruncate()`|`ftruncate(file,length)`|将文件截断到指定的长度|
|`rename()`|`rename(oldName, newName)`|重命名文件呼呼目录|

- 文件的上传与下载 <br>

>1. 文件上传 <br>

(1) `enctype='multipart/form-data'` : 指定表单的编码方式
(2)`method='POST'` : 指明发送数据的方法
(3) 可以通过使用一个隐藏输入框限制文件上传大小，不过这是不可靠的，只是起到提醒的作用
```
<form action="upload.php" method='post' enctype='multipart/form-data'>
  <input type="hidden" name='MAX_FILE_SIZE' value='100000'>
  选择文件： <input type="file" name='myfile'>
  <input type="submit" value='上传文件'>
</form>
```


- 动态图像处理 <br>
  `GD库`

>1. 画布管理
```
imagecreatetruecolor((int x_size, int y_size)) : 建立的是一幅大小为 x 和 y 的黑色图像(默认为黑色)，
                       如想改变背景颜色则需要用填充颜色函数 imagefill($img,0,0,$color);
imagecreate(int x_size, int y_size) : 新建一个空白图像资源，用 imagecolorallocate() 添加背景色
imagedestroy(resource image) : 画布的句柄如果不再使用 ，一定要将其销毁，以释放内存与存储单元
```

>2. 设置颜色
```
imagecolorallocate($image, int red, int green, int blue) 
```

>3. 生成图像
```
bool imagegif(resource $image, [,string $filename])
bool imagejpeg(resource $image, [,string $filename [,int $quality]])
bool imagepng(resource $image, [,string $filename])
bool imagebmp(resource $image, [,string $filename])
```

在输出图像之前，必须使用 `headr()` 函数发送标头信息，用来通知浏览器使用正确的 `MIME` <br>
类型对接收的内容进行解析
```
// 输出一个 png 图片
header('Content-type:image/png');
imagepng($image);
```

- 绘制图像

图像填充
```
imagefill(resource $image, int $x, int $y)
```

- 图片处理

(1) 图片缩放
```
imagecopyresized()
imagecopyresized()
其中，后者处理效果更好
```

(2) 图片水印
```
imagecopy()
```

(3) 图片旋转和翻转
```
imagerotate()
```

## 数据库开发

- 基本操作
```
(1) 登录数据库：mysql -h localhost -u username -p pwd
(2) 创建数据库： create database bookstore;
(3) 彻底删除数据库：drop database bookstore;
(4) 显示数据库： show databases;
(5) 显示数据表： show tables;
(6) 创建数据表： create table book();
(7) 插入：insert into book(bookname,price) value('细说php',89.00);
(8) 查询：select * from book;
(9) 更新：update book set price=89.88 where id=2;
(10) 删除：delete from book where id=2;
```

- 数据字段属性值

>1. `unsigned` <br>
>2. `zerofill` <br>
>3. `auto_increment` <br>
>4. `null` and `not null` <br>
>5. `default` <br>

- 索引

```
(1) 主键索引： primary key
  cid int not null auto_increment primary key
(2) 唯一索引：unique
  catname varchar(15) not null unique
(3) 常规索引：index/key
  key ind (uid, bid)
(4) 全文索引：fulltext
  detail text not null,
  fulltext (detail)
```

- Tip

将 `.sql` 类型的文件导入数据库
```
mysql -uroot -proot shop < g:/phpStudy/WWW/shop/shop.sql
```

## MemCache

## 会话控制

- `Cookie` <br>   

(1) 设置: `setCookie()`
```
setCookie('username','skygao',time()+60*60*24*7);
setCookie('username','skygao',time()+60*60*24*7,'/test','.example',1);
```

(2) 访问: `$_COOKIE`
```
setCookie('user[username]','skygao')

$_COOKIE['user']['username']
```

(3) 删除
```
// 第一种方式， 只指定第一个参数，浏览器关闭则 cookie就会被立即删除
setCookie('username');

// 第二种方式，将过期时间设置为当前时间之前
setCookie('username','',time()-1);
```

- `Session` <br>

(1) 声明与使用
```
// 首先必须启动 session
session_start();

// 注册
$_SESSION['username']='skygao';
```

(2) 注销
```
// 开启session
session_start();

// 删除所有session， 也可以使用 unset($_SESSION[xxx]) 逐个删除
$_SESSION=array();

if(isset($_COOKIE[session_name()])) {
  setCookie(session_name(),'',time()-1,'/');
}

// 彻底销毁 session 所存储的文件
session_destroy();
```


## CURL




