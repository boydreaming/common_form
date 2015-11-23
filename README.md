# common_form
common form
##common是什么
一个通用表单核心调用模块


 * 文件作用描述：通用增，删，改界面模块
###调用方法 ：
 require ("../common_v3.php");

###外部程序的变量说明：
 1.(version 3 的表必须含有一个primary_key的字段)
 
 2.避免采用common_ 为前缀的变量
 
 3.version 3 样式尽量外挂$common_style_table

* $common_mod: 方式(list,add,edit,ext_list)
* $common_dbname   数据库名
* $common_tbname 表名
* $mainindex 返回的主程序 (若空不显示“退出”按钮)
* $common_sql 复合SQL查询语句，若使用可省common_tbname

###外部程序可定义的变量：
* $common_style_table: 表格样式，比如 $common_style_table="class=bordered";    
* $common_style_addbutton:"增加"按钮的样式
* $common_style_button:其他按钮样式
* $common_search_field:被搜索的关键字段
* $common_type: 该变量决定是否具有增加、删除、修改功能；默认为“|add|del|edit|list|query|filter|search|”,定义为“|list|”时，只能浏览。
* $common_chsfield : 字段中英对照
        如:$common_chsfield=Array("case_info_id_a"=>"处理单编号", "customername"=>"户名")
* $ext_filter:(0|1)是否采用外部条件,与$common_condition,$common_fields配对
* $common_condition: 条件变量 sql 语句 where后的字符串,如有必要可加urlencode,采用search模式后，该值会被忽略
* $common_fields:  指定要显示哪些字段，以","分隔,索引字段必须有
* $common_sort: 排序字段名称
* $common_ar_<字段名> : 外部输入式样,需数组类型. 用于生成如单选输入框的式样
* $common_rel_<字段名>:  如果$common_ar_<字段名>是多维数组，将生成关联数组，例如：$common_rel_papertype1=array("papertype1"=>"papertype2");　表示papertype1,papertype2形成关联，则papertype1决定papertype2.支持最多三个关联，如：$common_rel_truename=array("truename"=>array("operator","department"));
* $common_perpage:  每页多少记录数
* $common_ap_<字段名>: 在INPUT中追加样式，" disabled"; 可使相应输入框为灰,"readonly" 可使相应输入框为只读，"hidden" ,可使输入框隐藏,同时"hidden"也可使其在列表中不显示也可借此调用javascript，如onfocus,onclick等
* $common_ap_commonfrm: 控制commonfrm 的提交后面的控制，可控制onsubmit等脚本   默认为onSubmit='submitonce(this)'
* $common_default_<字段名> 默认值
* $common_str_edit:“修改”按钮自定义
* $common_str_add:“增加”按钮自定义
* $common_buttons: 追加显示的按钮
* $common_extprg: 让<增加><修改>显示均调用外部程序,外部程序只有两个接口，调用模式$common_mod,当前索引值$common_id,点击其他字段列会进行"显示模式"
* $common_extprg_<字段名>: 可定义相应字段所调用的外用程序,调用模式用$common_extprg,该字段不会在编辑中显示出来
* `$common_extprg_<字段名>_button`: 可自定义相应字段提示按钮样式，默认为“按此”
   如果button是完全自定义如`<button onclick=open(#common_id)>`之类，将会使用该自定义样式。
   注1：如果要引用$common_id,需采用#common_id.
   注2：$common_extprg_<字段名>也必须存在
* $common_link_<字段名>:定义某一字段显示时可超链至另一页面,会自动追加该字段的值至url中。
* $common_submit_out 在提交后的处理，包括增，删，改。如 	$common_submit_out="./test.php";代码内容如print_r($_POST);
* $common_button: 该变量控制是否先给出一个查询框，如果外部传入该变量值为1，说明具有查询功能，由外部传入查询条件$common_condition，第一次是变量传入，
  调用common_mod=list模块，以后修改、增加、删除时用url变量传入(因为回调时$common_condition再次得到打开页面同名输入框的值，和最初值不一样了)，
  调用common=list_condition模块
* $common_ext_deal: 外部传入该变量则说明需要外部处理,仍然使用本页的<增加><修改>,结束后,回调时调用$mod==ext_deal,
* $common_titlecolor: 列表标题背景色
* $common_linecolor: 详细行背景色
* $common_alterlinecolor: 交替详细行背景色
* $common_condition_linecolor: array() 根据某个字段条件设定该行背景色 采用数组，支持多条件，与common_condition_linecolor_col or配对使用
* $common_condition_linecolor_color: 根据某个字段条件设定该行背景色 array()
* $common_js_date: 是否启动默认调用日期时间控件，默认调用true。数据库字段为date启用日期，为datetime启用日期时间，调用控件路径在./_common下
* $common_meg:自定义显示信息 位置在“--显示记录--”后
* $common_footer:页面底部显示内容
* $common_attach_<字段名>: 0为默认，1为该字段保存附件，将保存16位字长的唯一编码;该功能需要调用 attachment.php;该功能                          需要$common_fields 中有定义，删除记录后，会调用attachment.php删除相应内容。
* $common_after_del:删除记录后的追加操作,可以传送的参数为#common_delid
* $common_lock_style:默认为 overflow:auto;width:100%;height:450px; 会影响总体长宽
* $common_title:页面标题
* $common_after_del:删除后跳转执行

##css和javascript的说明

* javascript  可能通过$common_ap_<字段名> 来调用js
  ./_common/common.js有本程序调用的javascript


###其它注意:
 1、避免变量重复，外部程序，在调用本程序时，应避免用common打头的变量，以及不应用表中FIELD同名的变量。
 
 2、外部访问模式common_mod可为list,add,edit,需要注意的是,主程序要对这些变量做判断,因为它会回调主程序的,然后,再进入本程序
 
 3、与common.php主要不同在于，必须有primary_key,不再支持common的附件上传模式


##有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* QQ: 2406545

```