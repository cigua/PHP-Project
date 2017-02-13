# 跟着兄弟连学PHP

---

- 类

>1. 封装性

(1) `__set()` <br>
    当为对象的私有成员设置值的时候，自动调用此函数，可以在此函数中进行诸如过滤之类的额外操作，<br>
    没有返回值。

(2) `__get()` <br>
    直接在对象的外部获取私有属性的值时，自动调用此方法，可以在此函数中进行诸如限制访问之类的额外操作， <br>
    返回私有属性的值。

(3) `__isset()` <br> 
    `isset()` 用于检测变量是否存在，同样可以对象中的公有成员属性进行检查，但是如果成员属性<br>
    为私有属性，则需要间接使用 `__isset()` <br>
    如果类中添加此方法，在对象的外部使用 `isset()` 函数检测对象成员时，自动调用 `__isset()` 函数

(4) `__unset()` <br>
    `unset()` 函数用于删除指定的变量，也可以使用此函数在对象外部删除对象中的公有成员属性， <br>
    如果想要删除私有成员属性，则需要添加 `__unset()` 方法，同时可以在此方法中增加一些诸如限制删除的条件等操作 <br>


>2. 继承性

(1)`PHP` 和 `Java` 一样，没有多继承，只能说会用单继承模式，也就是说，一个类只能直接从另一个类中 <br>
继承数据，但一个类可以有多个子类。

(2) 访问控制符

| |`private`|`protected`|`public`(默认)|
|---|---|---|---|
|同一个类中|√|√|√|
|类的子类中||√|√|
|所有的外部成员|||√|

- 覆写父类中的方法

子类可以直接覆写父类中的方法，但如果不是完全改变父类的方法实现，而只是对其进行小幅度的修改，<br>
例如在方法中增加部分操作，那么可以使用 `parent` 关键字实现，减少代码冗余
```
class Person { 
  protected $name;

  function __construct($name='') {
    $this->name=$name;
  }

  function say() {
    echo 'My name is '.$this->name;
  }
}

class Student extends Person {
  private $school;

  function __construct($name='',$school) {
    // 覆盖并增加成员属性
    parent::__construct($name);
    $this->school=$school;
  }

  function say() {
    parent::say();
    // 覆盖并增加操作
    echo ', and study at '.$this->school.'<br>';
  }
}
$student = new Student('zhangsan','schools');
$student->say();
```

> 在子类中覆写父类的方法，访问权限必须不小于父类中被覆写的方法的访问权限，<br>
例如，如果父类中方法的访问权限是 `protected`， 那么子类中重写此方法的权限必须要是 `protected` 或者 `public`

- 常见的关键字和魔术方法

>1. `final` <br>
  - 加在类或类的方法前，使用 `final` 标识的类。不能被继承
  - 在类中使用 `final` 标识的成员方法，在子类中不能被覆盖
```
// 此类不可被继承
final class MyClass {
  // ...
}

class Person {
  // 此函数不可被子类重写
  final run() {
    // ...
  }
}
```

>2. `static` 与 `self` <br>
  `static` 可以将类中的成员标识为静态的，静态的成员将会作为类的属性存在， <br>
  所有根据此类实例化出来的对象，都将具有此静态成员，可以在多个对象之间共享， <br>
  类似于函数中的全局变量，使用 `类名::静态成员属性名` 或者 `类名::静态成员方法名()` <br>
  的形式来访问。 <br>
  静态成员属于类，而不属于对象，所以无法使用 `$this` 引用，可以使用 `self` 关键字让类的成员 <br>
  来访问类中的静态成员属性 <br>
  类中的静态方法只能方法静态成员属性

```
class MyClass {
  // 静态成员
  static $count;

  function __construct() {
    // 使用 self 引用类中的静态成员
    self::$count++;
  }
  // 静态函数
  static function getCount() {
    // 使用 self 引用类中的静态成员
    return self::$count;
  }
}
// 在类的外部引用类中的静态成员
MyClass::$count=0;

// 每多实例化一个对象，就会调用类的 __construct() 方法一次，
// 类中的静态成员 $count 就自动加 1
$myc1=new MyClass();
$myc2=new MyClass();
$myc3=new MyClass();

// 使用类名访问，通常做法
echo MyClass::getCount();     // 3
// 也可以使用对象引用
echo $myc2->getCount();       // 3
```

>3. 单例模式 <br>
  关键在于将类的构造函数 `__construct()` 封装成 `private`
```
// 封装成私有方法后，就无法在外部实例化了
private function __construct() {
  // ...
}
```
>4. `const` 关键字 <br>
    要将类中的成员属性定义为常量，无法使用 `define()`函数 ，只能通过 `const` 关键字来完成 <br>
    同时无需使用 `$` 符号，使用 `const` 关键字标识的成员属性，访问方式与`static` 静态成员属性的相同 <br>
    从 `PHP 5.3` 版本开始，`const` 也能够在类外声明变量，但与 `define` 还是有些区别，如在 命名空间 中， <br>
    `define` 的作用域是全局的，而 `const` 则只作用于当前空间
```
class MyClass {
  // 定义类的一个常量, 常量名最好大写
  const CONSTANT = 'CONSTANT value';
  function showContant() {
    // 访问常量的方式与访问静态成员相同
    echo self::CONSTANT;
  }
}

// 第一种访问方式，使用类名
echo MyClass::CONSTANT.'<br>';
// 第二种访问方式，使用实例化出来的对象
$class=new MyClass();
$class->showContant();
```

>5. `instanceof` 关键字 <br>
    用于确定一个对象是类的实例、子类，还是实现了某个特定接口
```
$man=new Prson();
// 检测 $man 是否为 Person 的实例
if($man instanceof Person) {
  // ...
}
```

>6. `clone` 关键字 <br>
  克隆对象，建立对象的一个副本
```
$p1=new Person('zhangsan','male',20);
// 复制 $p1
$p2=clone $p1;

$p2->name='lisi';
// 二者不会相互影响
echo $p1->name;
echo $p2->name;
```

在类中覆写 `__clone()` 方法，则复制对象时，将自动执行此方法
```
class Person {
    private $name;
    private $gender;
    private $age;

    function __construct($name='',$gender='',$age=18) {
      $this->name=$name;
      $this->gender=$gender;
      $this->age=$age;
    }
    // 声明此方法，则在对象克隆时在自动调用，用来为新对象重新赋值
    function __clone() {
      $this->name='zhangsan2';
      $this->age=10;
    }
    function say() {
      echo $this->name.', '.$this->gender.', '.$this->age.'<br>';
    }
  }


  $p1=new Person('zhangsan','male',20);
  // 复制 $p1
  $p2=clone $p1;

  $p1->say();
  $p2->say();
```

>7. `__toString()` <br>
  当使用 `echo` 输出类的实例化对象时，将会自动调用类中的 `__toString()` 方法，<br>  
  如果此方法没有在类中覆写，则会报错
```
class Person {
  private $name;
  function __construct($name) {
    $this->name=$name;
  }
  function __toString() {
    return $this->name;
  }
}

$obj=new Person('zhangsan');
// 自动调用类中的 __toString() 方法
echo $obj;
```

>8. `call()` 方法 <br>
  在类中添加此方法后，如果调用对象中不存在的方法就会自动调用该方法，并且程序会正常往下运行， <br>  
  而不是直接报错

```
function __call($functionName, $args) {
  echo '你所调用的函数：'.$functionName.'(参数：';
  print_r($args);
  echo ')不存在！';
}
```

>9. `autoload()` <br>
    自动加载类 <br>
    想要使用好此函数，最好在组织类的文件名时按照一定的规则，一定要以类名为中心， <br>
    也可以加上统一的前缀或后缀形成文件名，比如 `classname.class.php`
  
```
function __autoload($className) {
  include(strtolower($className).'.class.php');
}

// User 类如果不存在则自动调用 __autoload() 函数，将类名  User 作为参数传入
$obj=new User();
```

>10. `serialize()` 与 `unserialize()` <br>
    `__sleep()` 与 `__wakeup()` <br>
    对象序列化(将对象转换成二进制字符串)，反序列化(将字符串转换成对象) <br>
    调用 `serialize()` 时，将自动调用对象中的 `__sleep()` 方法，用来将对象中的部分成员序列化， <br>
    调用`unserialize()`时，将自动调用对象中的 `__wakeup()` 方法，用来在二进制字符串反序列化为对象时， <br>
    为新对象中的成员属性重新初始化
  
在如下两种情况下必须把对象序列化：
```
(1) 对象需要在网络中传输时
(2) 对象需要持久化保存时(例如存入文件或者数据库)
```

- 抽象类 <br>
  为了方便继承而引入的，子类继承了抽象父类之后，必须实现父类中所有的抽象方法，<br>  
  否则子类就将因为继承了抽象类没有实现而也变成抽象类，无法进行实例化

>1. 抽象方法 <br>
    没有方法的方法， 也就是说没有花括号以及括号内的内容，直接使用分号结束声明，
    使用关键字 `abstract` 进行修饰
  
```
  // 一个名为 fun1 的抽象方法
  abstract function fun1();
```

>2. 抽象类 <br>
  只要类中存在抽象方法，那么这个类就是抽象类，使用 `abstract` 关键字来修饰 <br>
  抽象类无法被实例化，只能通过子类来实现，在抽象类中可以有不是抽象的成员方法和属性， <br>
  但访问权限不能使用 `private` 关键字修饰为私有的

```
abstract class Person {
    protected $name;
    protected $country;

    function __construct($name='',$country='') {
      $this->name=$name;
      $this->country=$country;
    }
    // 抽象类除了抽象方法外，还可以有其他非抽象方法
    function run() {
      echo ',run good'.'<br>';
    }

    // 定义了抽象类，方便子类继承覆写
    abstract function say();
  }

  class ChineseMan extends Person {
    // 子类必须重写父类的所有抽象方法
    function say() {
      echo $this->name.' is in '.$this->country;
    }
  }

  class Americans extends Person {
    // 子类必须重写父类的所有抽象方法
    function say() {
      echo $this->name.' is in '.$this->country;
    }
  }

  $chineseMan=new ChineseMan('zhangsan','chinese');
  $americans=new Americans('John','American');

  $chineseMan->say();
  $americans->say();
  $chineseMan->run();
```

>3. `interface` <br>
  接口是一种特殊的抽象类，同样不能被实例化，接口中声明的方法必须都是抽象方法， <br>
  并且不能在接口中声明变量，只能使用 `const` 关键字声明为常量的成员属性， <br>
  接口中所有的成员都必须有 `public` 访问权限，使用 `interface` 进行标识 <br>
  一个类只能有一个父类，但可以有多个接口

```
interface One {
  // 成员属性只能是常量
  const CONSTANT = 'CONSTANT value';
  // 因为接口中只能有抽象方法，所以这里无需使用 abstract 进行标识
  function fun1();
  function fun2();
}
```

接口之间的继承使用 `extends` 关键字，但是如果想要实现接口中的抽象方法，
则需要使用 `implements` 关键字
```
// 使用 implements 继承接口
abstract class Three implements One {
  // 因为此类是抽象类，所以可以实现接口中的部分方法，也可以不实现
  function fun1() {
    // ...
  }
}

// 使用 implements 继承接口
class Four implements One {
  // 非抽象类，所以必须实现接口中所有方法
  function fun1() {
    // ...
  }
  function fun2() {
    // ...
  }
}
```

继承多个接口：
```
// 继承一个类的同时实现多个接口
class fifth extends implements Sixth, Seventh {
  // ...
}
```

- `Trait` <br>
  类的特性 `Trait` 一般都有，支持 `final static abstract`，无法实例化， <br>
  混在类中使用，从 `PHP 5.4` 版本开始支持

>1. 声明
```
trait Person {
  public $name='zhangsan';
  private $age=18;
  function run() {
    // ...
  }
  abstract public function say() {
    // ...
  }
}
```

>2. 基本使用 <br>
  使用 `use` 关键字将 `trait` 定义的类混入其他类中使用，类似于 `mixin`

```
trait demo {
    function method1() {
      echo 'good';
    }
  }

  class demo2 {
    // 使用 use 将 trait 混入类中
    use demo;
  }

  $obj=new demo2;
  $obj->method1();    // good
```

(1) 在一个类中使用多个 `trait`，使用逗号分割
```
class demo3 {
  use trait1, trait2, trait3;
}
```

(2) 使用 `insteadOf` 避免多个 `trait` 之间的方法产生冲突：
```
trait trait1 {
  function func() {
    echo 'first';
  }
}
trait trait2 {
  // 与第一个 trait1 中的 func 方法冲突
  function func() {
    echo 'second';
  }
}
class classTest {
  use trait1, trait2 {
    // 声明使用 trait1 中的 func 替换 trait2 中的func
    trait1:func insteadOf trait2;
  }
}

$obj=new classTest;
$obj->func();         // first
```

(3) `trait` 嵌套 <br>

```
trait trait1 {
  function func1 {
    // ...
  }
}
trait trait2 {
  // 嵌套 trait1
  use trait1;
  function func2() {
    // ...
  }
}
```

(4) 在 `trait` 中使用 `abstract` 抽象方法


- 命名空间 <br>
  从 `PHP 5.3` 版本开始支持

>1. 基本使用 <br>
  使用 `namespace` 关键字声明，并且必须是在脚本的最顶部，也就是第一个`PHP` 指令(`declare` 除外) <br>
  指令命名空间无法嵌套，使用一种类似于文件路径的语法`\` 访问命名空间

```
// MyProject1 的开始
namespace MyProject1;
  const TEST = 'this is a const';
  function demo() {
    echo 'this is a function'.'<br>';
  }
  class User {
    function fun() {
      echo 'this is User\'s fun()'.'<br>';
    }
  }

  echo TEST.'<br>';
  demo();

  // MyProject1的结束，同时也是 MyProject2 的开始
  const TEST2='this is MyProject2 const';
  echo TEST2.'<br>';

  // 使用路径格式访问 MyProject1 中的成员
  \MyProject1\demo();

  $user=new \MyProject1\User();
  $user->fun();
  /*
    this is a const
    this is a function
    this is MyProject2 const
    this is a function
    this is User's fun()
  */
```

>2. 子空间和公共空间

```
// 表示位于 broshop 空间下的子空间cart
namespace broshop\cart
```

>3. 别名和导入 <br>
    需要注意的是，**`PHP` 不支持导入函数和常量，但是文件和命名空间可以导入**

(1) 使用 `use...as` 关键字导入命名空间并为之创建别名
```
use cn\ydma as u;
```

## 字符串处理

>1. 获取字符串单个字符 <br>
    使用中括号 `[]` 可获取单个字符，但这容易带来与数组之间的二义性，所以从 `PHP 4` 开始已经过时， <br>
    使用 大括号 `{}` 来代替

>2. `ord()` 与 `chr()` <br>
    字符与字符编码之间互相转换

>3. 双引号中的变量解析

>4. 常用的字符串输出函数

|函数名|功能描述|示例|
|---|---|---|
|`echo()`|输出一个或多个字符串|`echo $lamp['os'],$lamp['db']`|
|`print()`|与 `echo()` 相同，但是有返回值，<br> 成功返回 `1`，失败返回 `0`， 效率比 `echo` 低|`print($lamp['os']);`|
|`die()`|`exit()` 函数的别名，输出一条消息，并退出当前脚本 <br>|`die("Unable to open");`|
|`printf()`|输出格式化的字符串|`printf('%s get %d',$lamp['os'],$lamp['good']);`|
|`sprintf()`|把格式化的字符串写入一个变量中|`$txt=sprintf('%s get %d',$lamp['os'],$lamp['good']);`|

>5. 常用的字符串格式化函数

|函数名|功能描述|示例|
|---|---|---|
|`ltrim()`|从字符串左侧删除空格或其他预定义字符|`$txt=ltrim('  nice  ');`|
|`rtrim()`|从字符串末端删除空格或其他预定义字符|`$txt=rtrim('  nice  ');`|
|`trim()`|从字符串两侧删除空格或其他预定义字符|`$txt=trim('  nice  ');`|
|`str_pad()`|把字符串填充为新的长度|`$txt=str_pad('nice',15);`|
|`strtolower()`|把字符串转为小写|`strtolower('NICE');`|
|`strtoupper()`|把字符串转为大写|`strtoupper('nice');`|
|`ucfirst()`|把字符串中的首字母转为大写|`ucfirst('nice');`|
|`Ucwords()`|把字符串中每个单词的首字符转换为大写|`Ucwords('nice');`|
|`nl2br()`|在字符串中的每个新行之前插入`HTML`换行符`<br>`|`nl2br('nice');`|
|`htmlentities()`|把字符串转换为`HTML` 实体|`htmlentities('nice');`|
|`htmlspecialchars()`|把一些预定义的字符转换为`HTML` 实体|`htmlspecialchars('nice');`|
|`Stripslashes()`|删除由 `addcslashes()` 函数添加的反斜杠|`Stripslashes('nice');`|
|`strip_tags()`|剥离`HTML XML PHP` 标签|`strip_tags('nice');`|
|`number_format()`|通过千位分组来格式化数字|`number_format('nice');`|
|`strrev()`|反转字符串|`strrev('nice');`|
|`md5()`|将字符串进行`MD5` 计算|`md5('nice');`|

- 字符串比较函数

>1. 按字节顺序进行字符串比较 <br>
    `strcmp()  strcasecmp()`

>2. 按自然排序进行字符串比较 <br>
    `strnatcmp()`

## 正则表达式

>1. 定界符 <br>

除了字母、数字和反斜线`\` 以外的任何字符都可以作为定界符号， <br> 
例如 `/  #  !  |` 等

>2. 字符串的匹配与查找 <br>

(1) `preg_match()` <br>
  在第一次匹配成功之后就会停止搜索

(2) `preg_match_all()` <br>
  不会在第一次匹配成功之后就停止搜索，而是一直搜索到字符串的结尾，获取所有匹配到的结果

(3) `preg_grep()` <br>
  用于匹配数组中的元素，返回与正则表达式匹配的数组单元

(4) `strstr()` <br>
  搜索一个字符串在另一个字符串中第一次出现的位置，并返回从这个位置开始之后所有的字符串，<br>
  如果没有找到则返回 `FALSE`

(5) `strpos()` <br>
  搜索一个字符串在另一个字符串中第一次出现的位置，并返回下标，如果没有找到则返回 `FALSE` <br>
  与此类似的是， `strrpos()` 则返回最后一次出现的位置下标，这两个函数都是大小写敏感 <br>
  如果需要不区分大小写，则使用 `stripos()` 和 `strripos()` 代替

(6) `preg_replace()` <br>
  字符串替换
```
$txt='this is nice!';
$pattern='/\bnice/';
echo preg_replace($pattern,'good',$txt);
```
如果只是简单的字符串替换，则考虑使用 `str_replace()`，因为效率更高, <br>
如果无需区分大小写，则使用 `str_ireplace()`

(7) `preg_split()` <br>
  如果只是分割某个特定的字符串，则建议使用效率更高的 `exploade()`

(8) `implode()` <br>
  与 `preg_split()` 对应，作用是将数组中的所有元素组合成一个字符串 <br>
  `join()` 是其别名




