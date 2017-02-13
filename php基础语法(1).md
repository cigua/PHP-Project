# 跟着兄弟连学PHP(第3版)

---

- 可变变量
```
<?php
  $hi='hello';      // 与 python 一样，变量无需声明，直接使用
  $$hi='world';     // $hi 的值是hello， 相当于是声明 $hello 的值是 world

  echo $hi.$hello;
  echo $hi.$$hi;
?>
```

- 引用赋值
```
<?php
  $foo='Bob';
  // 将 `&` 符号加到将要复制的变量前，就完成了引用赋值
  // 接下来，$bar 和 $foo 之间就可以相互影响了
  $bar=&$foo;

  $bar='Tom';
  echo $bar;    // Tom
  echo $foo;    // Tom

  $foo='is Bob!';
  echo $bar;    // is Bob!
  echo $foo;    // is Bob!
?>
```
>不能使用**表达式**作为引用赋值
```
$bar = &(24 * 7);     // 这是无效的引用赋值
```

>`PHP`引用赋值只是将值关联在了一起，变量的内存并不同体。
```
<?php
  $foo=25;
  $bar=&$foo;
  // unset: 在内存中销毁指定的变量
  unset($bar);
  // 因为引用赋值与内存无关，所以销毁了 $bar，$foo 依旧存在
  echo $foo;    // 25
?>
```

- 数据类型

**4 种标量类型**

>(1) `boolean` (布尔型)

>(2) `integer` (整型)

>(3) `float` (浮点型，也称 `double`)

  浮点数只是一种近似值，如果使用浮点数表示 8，则该结果内部的表示其实类似 7.999999……<br>
  所以永远不要相信浮点数结果精确到了最后一位，也永远不要比较两个浮点数是否相等。<br>
  如果确实需要更高的精度，应该使用任意精度数学函数或者 `gmp()` 函数。<br>
```
  // 以下就说明了问题
  <?php
    echo (0.3 == 0.1+0.2 ? 'ok' : 'sorry');     // sorry
  ?>
```
>(4) `string` (字符串)

1. 单引号

在单引号字符串中出现的变量不会被变量的值替代，即 **`PHP` 不会解析单引号中的变量，而只是原样输出**。<br>
同时对于 **字符转义的支持度较低**，只能转义在单引号引起来的单引号以及转义字符本身，其余转义都会原样输出，<br>
所以，在定义不包含变量的简单字符串时，因为省去了解析等处理的操作，所以使用单引号效率更高，<br>
**如果没有特殊需求，应使用单引号定义字符串。**
```
$str=100;
// 这里将变量放到了单引号里面，只会将变量原样输出
echo 'the number is $str';  // the number is $str
// 这里只有 I\'m 以及 \\ 会被转义成功，其余都会原样输出
echo '\t I\'m John, \n and I write \\'    // \t I'm John, \n and I write \
```

2. 双引号

双引号能够处理更多特殊字符的转义序列, 定义在双引号中的变量也会被解析。
```
<?php
  $beer='hello';
  // 将进行解析变量操作
  echo "First:$beer";     // First:hello
  // 使用大括号指定变量名的范围
  echo "Second:${beer}s";
  // 另外一种使用大括号指定变量名范围的写法
  echo "Third:${beer}s";
  // PHP 解析器将尽可能多的取得 $ 符号后面的字符串作为变量名，
  // 这里因为不存在变量 $beers ，所以会报错
  echo "Fourth:$beers";
?>
```

- 定界符(`<<<`)
```
<?php
  // 用于定义编码格式
  @header('Content-type: text/html;charset=UTF-8');

  $str=<<<BEGIN
  这里是包含在定界符中的字符串，需要注意以下几点：
  结束标识符 BEGIN 所在的行，除了最后的语句结束分号之外，不能包含任何其他字符，
  包括空格以及空白制表符，甚至不能存在缩进，并且结束标识符之前的第一个字符必须是换行符，
  也就是说最后的结束标识符之前必须换行。
BEGIN;

echo $str;
?>
```
>定界符很容易定义大段字符文本，其功能与**双引号类似**，具备更多的转义功能、可以解析变量，<br>
与单引号和双引号相比，定界符无法初始化类成员。
```
// 这样是非法的
class foo {
  public $bar = <<<BOT
  hello
BOT;
}
```

**2 种复合类型**

>(1) array (数组)

`PHP` 中的数组可以被当成是真正的数组、列表、散列图、字典、集合、栈、队列使用，<br>
```
<?php
  $arr=array('foo' => 'bar', 12 => true);
  // 使用 print_r() 函数将 $arr 转为 string 类型，便于查看
  print_r($arr);    // Array ( [foo] => bar [12] => 1 )
  echo $arr['foo'];     // bar
  echo $arr[12];     // 1
?>
```
>(2) object (对象)

初始化一个对象，需要使用 `new` 关键字。
```
<?php
  class Person {
    // 这里的 var 属于历史遗留问题，旧版本的php需要声明变量，
    // 这里是为了兼容php4，现今版本的php完全可以省略下面这句
    var $name;

    function say() {
      echo 'Doing foo.';
    }
  }

  $p=new Person;

  $p->name='Tom';
  $p->say();
?>
```

**2 种特殊类型**

>(1) resource (资源)<br>
  用于保存外部资源的引用，以便于对资源进行相关操作。

```
// 保存文件资源的引用
$file_handle=fopen('info.txt','w');

// 保存对目录资源的引用
$dir_handle=opendir('C:\\windows');

// 保存对 mysql 的连接资源
$link_mysql=mysql_connect('localhost','root','123456');

// 保存对图片资源的引用
$img_handle=imagecreate(100,50);

// 保存对xml 资源的引用
$xml_parser=xml_parser_create();
```

>(2) NULL<br>
  不区分大小写

```
<?php
// 将变量直接赋值为 null
$a=null;

// 使用 unset() 销毁变量，使其为null
$b='value';
unset($b);

var_dump($a);
var_dump($b);
// $c 没有创建，为null
var_dump($c);
?>
```

**伪类型**
>(1) `mixed`<br>
  一个参数可以接受多种不同的类型，例如 `gettype()` 可以接受所有的 `PHP`类型，<br>
  `str_replace()` 可以接受字符串和数组。

>(2) `number`<br>
  一个参数可以是 `integer` 或者 `float`

>(3) `callback`<br>
  可以传递任何内置的或者用户自定义的函数，
  除了 `array()  echo() empty()  eval()  exit() isset() print() unset()`


- 类型转换

- 自动类型转换

>通常只有 4 种标量类型 (`integer  float  string  boolean`) 才能使用自动类型转换。<br>
自动类型转换遵循转换**按数据长度增加的方向进行**，以保证精度不降低。

```
(1) 有布尔值参与运算时，TRUE 转为整型 1，FALSE转为整型 0
(2) 有 NULL 参与运算，NULL 转为 整型 0 
(3) 有 integer 类型和 float 类型参与运算，把 integer 转为 float
(4) 字符串和数值型(integer  float)参与运算，字符串转为数字，再参与运算，<br>
    例如 '123kio' 转为 123 ,'123.98klde89' 转为 '123.98'
```

```
<?php
  $foo='100page';
  $foo += 2;    // integer 102
  $foo = $foo + 1.3;    // float 103.3
  $foo = null + '10 s';     // integer 10
  $foo = 5 + '10.05 yuan';    // float 15.05
?>
```

- 强制类型转换

两种强制类型转换的方法
>1. 在要转换的变量之前加上用括号括起来的目标类型
```
<?php
  $foo=10;
  $bar=(boolean)$foo;     // $bar 是 boolean 类型的 TRUE
?>
```
>2. 使用内置的转换函数


第一种方法的转换函数：
```
(1) (int)  (integer) : 转换成整型，不遵循四舍五入
(2) (bool)  (boolean) : 转换成布尔型
(3) (float)  (double)  (real) : 转换成浮点型
(4) (string) : 转换成字符串
(5 (array) : 转换成数组
(6) (object) : 转换成对象
```


第二种方法的转换函数：
```
(1) intval() : 转换成整型，不遵循四舍五入
(2) floatval() : 转换成浮点型
(3) strval() : 转换成字符串

(4) settype() : 这种转换函数，不同于以上所有转换方式，settype() 属于原地修改，
    也就是说，直接将变量本身修改成了其他类型。
    $foo = '5bar';
    $bar = true;
    settype($foo, 'integer');     // $foo 现在是 整型 5
    settype($bar, 'string');    // $bar 现在是 字符串 '1'
```

**自 `PHP5` 起，如果视图将对象转换为浮点数，将会发出一条 `E_NOTICE 错误`**。

- 类型测试
>1. `var_dump`<br>
  此函数返回表达式或变量的类型和值的格式，例如 `float(9.8) 、 string(5) "10.57"`

>2. `gettype()`<br>
  只返回变量的类型，例如 `double 、 string`

>3. `is_TYPE`
  判断是否属于特定类型。
```
(1) is_bool() : 判断是否是布尔类型
(2) is_int() is_integer() is_long() : 判断是否是整型
(3) is_string() : 判断是否是字符串
(4) is_array() : 判断是否是数组
(5) is_object() : 判断是否是对象
(6) is_resource() : 判断是否是资源类型
(7) is_null() : 判断是否为空
(8) is_scalar() : 判断是否是标量，也就是整数、浮点数、布尔型、字符串
(9) is_numeric() : 判断是否是任何类型的数字或数字字符串
(10) is_callback() : 判断是否是有效的函数名
```

- 常量
>1. `PHP` 中，一般情况下使用 `define()` 来定义常量，按照惯例，常量名全部大写，不需要加 `$` 符号<br>
  常量一旦定义就不能被重新定义或取消定义，只能等解析引擎自动释放，<br>
  常量只能是 **标量 (`boolean integer  float string`)** 四种类型之一<br>
  使用 `defined()` 函数来检测是否定义了某个常量。
```
define(string name, mixed value, [, bool case_insensitive])

string name : 常量的名称
mixed value ：常量的值或者表达式
[, bool case_insensitive] : 可选 bool 参数，默认为 false,
                            如果设置为 true，则常量名不区分大小写
```

```
define('CON_INT', 100);
define('FLO', 99.99);
define('STR', 'Hello', true);
```

>2. 内置常量

主要的内置常量如下：
```
PHP_VERSION : 当前 PHP 服务器的版本
M_PI : 数学中的 π

__FILE__ : 当前文件名
__LINE__ : 执行此常量代码的当前行数
__FUNVTION__ : 当前函数名
__CLASS__ ：当前类名
__METHOD__ : 当前方法名
```

- 运算符

>1. 求余 `%` <br>
  此操作会首先将参与运算的两个值转为整型，遵循自动转换规则。

>2. 处理字符变量的算术运算时，按照 `ASCII码` 进行运算，注意，**只能递增无法递减**
```
<?php
  $i='a';
  for($n=0; $n<26; $n++) {
    echo $i++."\n";
  }
?>
// a b c d e f g h i j k l m n o p q r s t u v w x y z
```

>3. 比较运算符<br>
```
(1) == : 可能使用自类型转换，返回布尔值
(2) === : 全相等运算符，必须满足数值和数据类型全都相等，才返回 TRUE
(3) <> 或 !=
(4) !== : 非全等于，数值不相等或者类型不相同返回 TRUE
```

- 循环语句
> `break` <br>
在循环(`for foreach while do...while  switch`)中使用 `break` 语句，<br>
默认跳出最近的一层循环，也可指定跳出的层数。
```
<?php
  $i=0;
  while(++$i) {
    switch($i){
      case 5:
        echo 'num 5';
        break 1;            // 退出 1 层
      case 10:
        echo 'num 10';
        break 2;            // 退出 2 层
    }
  }
?>
```

- `exit` 语句 <br>
>直接退出当前脚本，别名为 `die()`

- `goto`<br>
>有争议，谨慎使用
```
// 使用 goto 语句产生的循环
<?php
  $i=1;
  st:
    echo "count: {$i}<br>";

    if($i++ === 10) {
      goto end;
    }

  goto st;
  end:
  echo 'end';
?>
```
>注意，`goto` 一般用于 **跳出循环或跳转语句，并且只能在同一个文件和作用域跳转**，<br>
**无法跳出一个函数和方法，也无法跳到另外一个函数或者任何循环以及 `switch` 结构中。**

- 数组
>1. 数组的定义

(1) 字面量直接赋值，使用 键值对 形式
```
    // 键 为数字，可以不用必须从 0 开始
    $count1[0]=1;
    $count1[1]=2;

    // 键 为字符串
    $count2['ID']=200;
    $count2['name']='John';

    // 键 为数字与字符串混合
    $count3[9]=200;
    $count3['name']='John';

    // 不显式指定键，则默认使用从 0 开始的索引
    $count4[]='foo';
    $count4[]='bar';

    // 默认索引 与 显式指定键 混合使用
    $count5[]=1;            // 默认下标为 0
    $count5[14]='name';     // 指定非连续的下标为 14
    $count5[]='age';        // 紧跟在上一个下标之后，所以为 15
    $count5[]='gender';     // 16
    $count5[14]='weight';   // 重新给下标为 14 的元素赋值
    $count5[]='good';       // 重新赋值不影响默认索引的增加，这里索引为 17
```

(2) 使用 `array()` 函数构造数组
```
// 键值对形式，同样支持类型混合
$array1 = array('name'=>'zhangsan', 'age'=>18, 8=>12);

// 默认索引
$array2 = array('zhangsan', 18, 'man');

// 键值对 与 默认索引 混合，与字面量直接定义数组规则相同
$array3 = array(1, 12=>'zhangsan', 'man', 16=>'good');
```
(3) 多维数组的声明, 就是一维数组的嵌套

>2. 数组的遍历

(1) 使用 `for()` 循环<br>
    要求数组的下标必须是连续的数字索引，限制较大，很少使用
```
<?php
 $array1 = array('name','age','gender');
 // 使用 count() 函数获取数组长度
 for($i=0; $i<count($array1); $i++) {
   echo $array1[$i];
 }
?>
```

(2) 使用 `foreach()` 循环<br>
    此函数只能用于遍历 数组 和 对象(从php5开始)

第一种用法，只遍历数组的值: `foreach(array as $value)`:
```
<?php
 $array1 = array('name'=>'zhangsan', 'age'=>18, 8=>12);
 foreach($array1 as $value) {
   echo $value;
 }
?>
```

第二种用法，遍历数组的键值对: `foreach(array as $key=>$value)`:
```
<?php
 $array1 = array('name'=>'zhangsan', 'age'=>18, 8=>12);
 foreach($array1 as $key=>$value) {
   echo "$key : $value";
 }
?>
```

(3) 使用 `each()` 循环<br>
    类似于 `JS` 中的 迭代器，每次调用一遍，就会将指针下移一位，<br>
    如果超出了数组长度，则返回 `bool(false)`

```
<?php
 $array1 = array('name'=>'zhangsan', 'age'=>18, 8=>12);
 $name=each($array1);
 $age=each($array1);
 var_dump($name);
 echo "<br>";
 var_dump($age);
?>
```

(3) 使用 `list()` 循环<br>
    `list()` 不是真正的函数，而是 `PHP` 的语言结构，`list()` 用一步操作给一组变量进行赋值，<br>
    即把数组中的值赋给一些变量，类似于`JS` 中的解构。<br>
    `list()` 仅能用于数字索引的数组并假定数字索引从 0 开始。

```
<?php
 $array1 = array('zhangsan', 18, 'man');
 list($name1, $age1, $gender1)=$array1;
 // 使用逗号跳过任意元素
 list($name2,, $gender2)=$array1;
 list(,,$name3)=$array1;
?>
```
(4) `while` 、 `list()` 、 `each()` 联合使用遍历数组
```
<?php
 $array1 = array('zhangsan', 18, 'man');
 // 数组结尾返回 FALSE, 循环就会停止
 while(list($key, $value)=each($array1)) {
  echo "$key : $value";
 }
?>
```

>使用 `foreach()` 与 `while` 联合遍历的差别在于，<br>
`foreach()` 循环完成后，会自动将数组参数，内部指针指向数组的开头，恢复到数组的初始状态。<br>
而 `while` 联合遍历则不会自动调整指针，遍历完成后，指针就是停在了数组的末端，下次要想再次从头<br>
循环，必须调用 `reset()` 函数手动将指针调整到数组初始位置。

(5) 数组的内部指针控制函数
```
current() : 取得当前指针位置的内容资料
key() : 读取当前指针所指向资料的索引值
next() : 将数组中的内部指针移动到下一个单元
prev() : 将数组的内部指针移动到前一个单元
end() : 将数组的内部指针移动到最后一位
reset() : 将当前指针无条件移动到首位
```

>3. 预定义数组

|预定义数组名|说明|
|---|---|
|`$_SERVER`|变量由 `Web` 服务器设定，或者直接与当前脚本的执行环境相关联|
|`$_ENV`|执行环境提交至脚本的变量|
|`$_GET`|经由 `GET` 请求提交到脚本的变量|
|`$_POST`|经由 `POST` 请求提交到脚本的变量|
|`$_REQUEST`|经由 `GET POST Cookie` 机制请求提交到脚本的变量，因此该数组并不值得信任|
|`$_FILES`|经由 `POST` 文件上传而提交到脚本的变量|
|`$_COOKIE`|经由 `Cookie` 方法提交到脚本的变量|
|`$_SESSION`|当前注册给脚本会话的变量|
|`$_GLOBALES`|包含一个引用，指向当前脚本全局范围内存在的所有有效的变量，该数组的键名就是全局变量的名称|

>4. 数组的键/值操作函数

(1) `array_values()` <br>
    `array_values(array)` <br>
    唯一的参数为所要操作的数组，返回数组中所有值的数组，并且被返回的数组会自动按照顺序，建立从 0 开始递增的数组
```
<?php
 $contact = array("ID"=>1, 'name'=>'John', 'age'=>18);
 print_r(array_values($contact));
 // Array ( [0] => 1 [1] => John [2] => 18 )
?>
```

(2) `array_keys()` <br>
    `array_keys(array, [,mixed search_value], [,bool strict])` <br>
    返回数组中所有键组成的数组，并且被返回的数组会自动按照顺序，建立从 0 开始递增的数组
```
<?php
 $contact = array("ID"=>1, 'name'=>'John', 'age'=>18, 'nickname'=>'18');
 print_r(array_keys($contact, 18, true));
 // Array ( [0] => age )
?>
```

(3) `in_array()` 与 `array_search()`<br>
    `in_array(value, array, [,bool strict])` `array_search(value, array, [,bool strict])` <br>
    两个函数参数和功能基本相同，都是对 **值** 进行搜索，检查数组中是否存在某个值 <br>
```
<?php
 $contact = array("ID"=>1, 'name'=>'John', 'age'=>18, 'nickname'=>'18');
 if(in_array(1, $contact)) {
   echo 'Got it';
 }
 if(array_search(18, $contact, true)){
   echo 'Got it!';
 }
?>
```

(4) `array_key_exists()` 与 `isset()` <br>
    两个函数参数和功能基本相同，都是对 **索引或者键** 进行搜索，检查数组中是否存在某个键 <br>
    区别在于 `isset()` 对于数组中键值为 `NULL` 的返回 `FALSE` ，而 `array_key_exists()` 则返回 `TRUE`。
```
<?php
 $contact = array("ID"=>null, 'name'=>'John', 'age'=>18, 'nickname'=>'18');
 if(isset($contact['ID'])) {
   echo 'Got it';                     // 不会输出
 }
 if(array_key_exists('ID',$contact)){
   echo 'Got it!';                    // 输出 'Got it!'
 }
?>
```

(5) `array_flip()` <br>
    `array_flip(array)` <br>
    交换数组中的键和值，返回一个反转后的数组，如果同一个值出现了多次，则以最后一个键名为准，<br>
    如果原数组中的值的数据类型不是字符串或整数，函数将报错。
```
<?php
 $contact = array("ID"=>20000, 'name'=>'John', 'nickname'=>'John','age'=>18);
 print_r(array_flip($contact));
 // Array ( [20000] => ID [John] => nickname [18] => age )
?>
```

(6) `array_reverse()` <br>
    `array_reverse(array, [,bool preserve_keys])` <br>
    数组顺序翻转，返回新的数组
```
<?php
 $contact = array("ID"=>20000, 'name'=>'John', 'nickname'=>'John','age'=>18);
 print_r(array_reverse($contact));
 // Array ( [age] => 18 [nickname] => John [name] => John [ID] => 20000 )
?>
```

>5. 统计数组元素个数以及数组去重

(1) `count()` <br>
    `count(Array, [,int mode])` <br>
    返回数组中的元素个数，或者对象中的属性个数。
```
<?php
 $contact1 = array(
   "ID"=>20000, 'name'=>'John', 'nickname'=>'John','age'=>18,
   array('a','b','c')
 );
 $contact2 = array();
 $str='nice';
 print_r(count($contact1));       // 5
 print_r(count($contact1,1));     // 5+3= 8
 print_r(count($str));            // 1
 print_r(count($contact2));       // 0
?>
```

(2) `array_count_values()` <br>
    统计数组中所有值出现的次数，返回一个新数组，数组的键是原数组中的值，<br>
    数组的值是对应键在原数组中出现的次数， 不支持多维数组。
```
<?php
 $contact1 = array(
   "ID"=>20000, 'name'=>'John', 'nickname'=>'John','age'=>18
 );
 print_r(array_count_values($contact1));
 // Array ( [20000] => 1 [John] => 2 [18] => 1 )
?>
```

(3) `array_unique()` <br>
    用于删除数组中重复的值，并返回没有重复值的新数组，删除时如果出现重复值，<br>  
    在新数组中保存第一个，忽略后面所有的。
```
<?php
 $contact1 = array(
   "ID"=>20000, 'name'=>'John', 'nickname'=>'John','age'=>18
 );
 print_r(array_unique($contact1));
?>
// Array ( [ID] => 20000 [name] => John [age] => 18 )
```

>6. 使用回调函数处理数组的函数

(1) `array_filter()` <br>
    `array_filter(array, [,callback])` <br>
    使用回调函数过滤数组中的元素, 类似于 `JS 中的 filter()`

(2) `array_walk()` <br>
    `array_walk(array, callback, [,mixed userdata])` <br>
    对数组中的每个元素应用回调函数进行处理，如果成功返回 `TRUE`， 失败返回 `FALSE`，<br>
    类似于 `JS 中的 map()`
```
<?php
 function myfun1($value, $key, $rand) {
   echo "$key : $value => $rand";
 }

 $lamp=array('a'=>'Linux','b'=>'Apache','c'=>'Mysql');
 array_walk($lamp,'myfun1','nice=>');
?>
// a : Linux => nice=>b : Apache => nice=>c : Mysql => nice=>
```

(3) `array_map()` <br>
    `array_map(callback, array1, [,array2, array3...])` <br>
    如果只处理一个数组，则与 `array_walk()` 功能类似，
    但如果处理多个数组，则是同时处理多个数组对应位置的元素。
```
<?php
 // 处理单个数组
 function myfun1($v) {
   if($v==='Mysql') {
     return 'Oracle';
   }
   return $v;
 }
 $lamp=array('Linux','Apache','Mysql','PHP');
 print_r(array_map('myfun1',$lamp));
 // Array ( [0] => Linux [1] => Apache [2] => Oracle [3] => PHP )

 // 处理多个数组
 function myfun2 ($v1, $v2) {
   if ($v1 === $v2) {
     return 'same';
   }
   return 'different';
 }
 $a1=array('Linux', 'PHP', 'MySQL');
 $a2=array('Uniux', 'PHP', 'Oracle');
 print_r(array_map('myfun2',$a1,$a2));
 // Array ( [0] => different [1] => same [2] => different )

 // 如果回调函数为 null ,则将多个数组以数组的形式构造到一个新数组中，形成多维数组
 print_r(array_map(null,$a1,$a2));
 /*
  Array (
    [0] => Array ( [0] => Linux [1] => Uniux ) 
    [1] => Array ( [0] => PHP [1] => PHP ) 
    [2] => Array ( [0] => MySQL [1] => Oracle )
  )
 */
?>
```

>7. 数组的排序函数

**以下全部是原地排序，也就是说，直接在原数组上进行修改。**
|排序函数|说明|
|---|---|
|`sort()`|按照值从小到大的升序进行排序|
|`rsort()`|按照值从大到小的降序进行排序|
|`usort()`|按照用户自定义的回调函数进行排序|
|`asort()`|对数组进行从小到大的排序，并保持索引关系|
|`uasort()`|按照用户自定义的回调函数进行排序，并保持索引关系|
|`ksort()`|按照键从大到小的降序进行排序，为数组保存原来的键|
|`uksort()`|按照用户自定义的回调函数对键名进行排序|
|`natsort()`|用自然顺序算法对给定数组中的元素进行排序|
|`natcasesort()`|按照用户自定义的回调函数对键名进行排序，不区分大小写|
|`array_multisort()`|对多个数组或多维数组进行排序|

>8. 数组拆分、合并、分解与接合

(1) `array_slice()` <br>
    返回符合参数条件的新数组，不改变原来的数组

(2) `array_splice()` <br>
    返回删除掉元素之后的数组，原地操作，也就是说修改了原数组

(3) `array_combine()` <br>
    合并数组，两个必须的参数，第一个数组的值为新数组的键，第二个数组的值为新数组的值,返回合并后的新数组。

(4) `array_merge()` <br>
    合并多个数组，如果键名重复则按最后一个为准
    使用运算符 `+` 同样能够合并数组，但是如果键名重复，是按第一个为准

(5) `array_intersect()` <br>
    最少传入两个数组参数，求交集

(6) `array_diff()` <br>
    最少传入两个数组参数，求第一个数组与其他数组参数的差集

>9. 数组与数据结构

(1) `array_push()` <br>
    向第一个参数的数组尾部添加一个或多个元素(入栈)，返回新数组的长度 <br>
    如果只是添加一条数据，则推荐使用` array[key]=value` 形式，性能优化

(2) `array_pop()` <br>
    删除数组中的最后一个元素(出栈)，返回被删除掉的那个元素

(3) `array_unshift()` <br>
    向第一个参数的数组头部添加一个或多个元素，返回新数组的长度 <br>

(4) `array_shift()` <br>
    删除数组中最开始的一个元素(出栈)，返回被删除掉的那个元素

>10. 其他数组处理函数

(1) `array_rand()` <br>
    从数组中随即返回一个元素或多个元素组成的数组，如果没有指定第二个参数，<br> 
    或者指定的第二个参数值为`1`，则返回一个随即元素的键，否则返回右多个元素的键值对组成的数组

(2) `shuffle()` <br>
    将数组随机打乱顺序，成功返回 `TRUE`，失败返回 `FALSE`，<br> 
    打乱后的数组的键从 0 开始进行索引

(3) `array_sum()` <br>
    返回数组中所有数值(整数和浮点数)的总和，如果数组中存在其他类型的值，则直接跳过

(4) `rand()` <br>
    返回一个数值(可以是数字或字母)范围内数组

(5) `unset()` <br>
    删除数组中指定位置的元素，此操作不会重建索引，想要重新建立顺序索引，需要用到 `array_values()`
