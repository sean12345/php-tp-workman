# 例子 - thrift接口描述文件
#
# 编写这个文件是为了教会你如何写thrift接口描述文件。
# 第一个你应该掌握的知识点就是.thrift文件
# 支持shell的注释方式，那就是用#符号。

/**
* thrift的常用数据类型，如下所示：
*
* bool 布尔型，1个字节
* byte 有符号整数，1个字节
* i16 有符号16位整型
* i32 有符号32位整型
* i64 有符号64位整型
* double 64位浮点数值
* string 字符串类型
* binary 二进制数据类型（字节数组）
* list 单类型有序列表，允许有重复元素
* set 单类型无需集合，不允许有重复元素
* map&lt;t1,t2&gt; Map型（key:value）
*
*/


/**
* .thrift文件可以引用其他.thrift文件，这样就可以方便地把一些公共结构和服务囊括进来。
* 在引用其他.thrift文件时，既可以直接引用当前文件夹下的文件，也可以引用其他路径下的
* 文件，但后者需要在thrift编译工具编译时加上-I选项来设定路径。
*
* 如果希望访问被包含的.thrift文件中的内容，则需要使用.thrift文件的文件名作为前缀，
* 比如shared.SharedObject。我们在本例中引用了文件shared.thrift。
*/
include "shared.thrift"

/**
* Thrift支持对.thrift文件中的类型设定namespace，这样可以有效避免名字冲突。
* 这种机制在C++中也叫做namespace，而在Java中叫做Package。
* thrift支持针对不同的语言设置不同的namespace，比如下面的例子。
* thrift会在生成不同语言代码时，进行相应的设置。
*/
namespace cpp tutorial
namespace go tutorial
namespace java tutorial
namespace php tutorial
namespace perl tutorial

/**
* thrift还可以使用typedef来给类型起别名。
*/
typedef i32 MyInteger

/**
* Thrift也支持定义常量。
* 对于结构复杂的常量，支持使用JSON形式来表示。
*/
const i32 MY_NUM = 9853
const map&lt;string,string&gt; MY_MAP = {'hello':'world', 'goodnight':'moon'}

/**
* 你还可以定义枚举类型, 其被指定为32位整型。域的值是可以自定义的，而且
* 当不提供域的值时，默认会从1开始编号并递增。
*/
enum Operation {
ADD = 1,
SUBTRACT = 2,
MULTIPLY = 3,
DIVIDE = 4
}

/**
* 结构体则是一个复杂的数据类型。它由多个域组成，每个域会对应一个整数标识符，
* 每一行的格式为：一个冒号，一个类型，一个域名称和一个（非必填的）默认值。
*
* 每个域都可以设置为optional或required来表示是否为必填域，以便thrift决定是否
* 在数据传输时要包含这个域。不指定时，默认为required。
*/
struct Work {
1: i32 num1 = 0,
2: i32 num2,
3: Operation op,
4: optional string comment,
}

/**
* 在语法上，异常的定义方式和结构体是完全一样的。在发生问题时，可以抛出异常。
*/
exception InvalidOperation {
1: i32 what,
2: string why
}

/**
* 啊哈，我们现在到了最Cool的环节，即定义服务。
* （一个服务可以使用extends来继承另一个服务。）
*/
service Calculator extends shared.SharedService {

/**
* 服务中方法的定义非常类似于C语言的语法。它会包括一个返回值，
* 一个参数列表以及一个可以抛出的异常列表（可选）
* 可以提前告诉大家的是，定义参数列表的方法、定义异常列表的方法，
* 和定义结构体的方法都是相似的，可以从下面的例子中看出。
* 除了最后一个方法，其他的方法最后都要有一个逗号，大家可不要忽略这个细节。
*/

void ping(),

i32 add(1:i32 num1, 2:i32 num2),

/**
* 在异常列表前，需要加throws关键字。
*/
i32 calculate(1:i32 logid, 2:Work w) throws (1:InvalidOperation ouch),

/**
* 如下的这个方法有一个oneway修饰符，还记得他的作用么
* 这表示这个方法在调用后会立即返回，不会等待远端的回复。
* 要注意的是，oneway只能修饰void返回类型。
* oneway在英语里就是“单向”的意思，还是很形象滴。
*/
oneway void zip()

}

/**
* 在你使用thrift编译工具编译此文件后，
* 会在当前目录产生一个“gen-&lt;你选择的开发语言&gt;”
* 文件夹，比如你选择的是C++语言，则会产生gen-cpp文件夹，
* 里面放着的便是thrift帮你生成好的代码，
* 代码并不那么晦涩，你可以打开看一看。
*/
