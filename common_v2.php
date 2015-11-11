<?
/**
 * 文件作用描述：通用增，删，改界面模块
 调用方法 ：
 require ("../common_v2.php");
//===========
 外部程序的变量说明：1.(version 2 的表必须含有一个primary_key的字段)
                     2.避免采用common_ 为前缀的变量
//===========
 $common_mod: 方式(list,add,edit,ext_list)
 $common_dbname   数据库名
 $common_tbname 表名
 $mainindex 返回的主程序 (若空不显示“退出”按钮)
 $common_sql 复合SQL查询语句，若使用可省common_tbname

//===========
 外部程序可定义的变量：
//===========
 $common_search_field:被搜索的关键字段
 $common_type: 该变量决定是否具有增加、删除、修改功能；默认为“|add|del|edit|list|query|filter|search|”,定义为“|list|”时，只能浏览。
 $common_chsfield : 字段中英对照
                   如:$common_chsfield=Array("case_info_id_a"=>"处理单编号", "customername"=>"户名")
 $ext_filter:(0|1)是否采用外部条件,与$common_condition,$common_fields配对
 $common_condition: 条件变量 sql 语句 where后的字符串,如有必要可加urlencode,采用search模式后，该值会被忽略
 $common_fields:  指定要显示哪些字段，以","分隔,索引字段必须有
 $common_sort: 排序字段名称
 $common_ar_<字段名> : 外部输入式样,需数组类型. 用于生成如单选输入框的式样
 $common_rel_<字段名>:  如果$common_ar_<字段名>是多维数组，将生成关联数组，例如：$common_rel_papertype1=array("papertype1"=>"papertype2");　表示papertype1,papertype2形成关联，则papertype1决定papertype2.支持最多三个关联，如：$common_rel_truename=array("truename"=>array("operator","department"));
 $common_perpage:  每页多少记录数
 $common_ap_<字段名>: 在INPUT中追加样式，" disabled"; 可使相应输入框为灰,"readonly" 可使相应输入框为只读，"hidden" ,可使输入框隐藏,同时"hidden"也可使其在列表中不显示也可借此调用javascript，如onfocus,onclick等
 $common_ap_commonfrm: 控制commonfrm 的提交后面的控制，可控制onsubmit等脚本   默认为onSubmit='submitonce(this)'
 $common_default_<字段名> 默认值
 $common_str_edit:“修改”按钮自定义
 $common_str_add:“增加”按钮自定义
 $common_buttons: 追加显示的按钮
 $common_extprg: 让<增加><修改>显示均调用外部程序,外部程序只有两个接口，调用模式$common_mod,当前索引值$common_id,点击其他字段列会进行"显示模式"
 $common_extprg_<字段名>: 可定义相应字段所调用的外用程序,调用模式用$common_extprg,该字段不会在编辑中显示出来
 $common_extprg_<字段名>_button: 可自定义相应字段提示按钮样式，默认为“按此”
                       如果button是完全自定义如<button onclick=open(#common_id)>之类，将会使用该自定义样式。
                       注1：如果要引用$common_id,需采用#common_id.
                       注2：$common_extprg_<字段名>也必须存在
 $common_link_<字段名>:定义某一字段显示时可超链至另一页面,会自动追加该字段的值至url中。
 $common_submit_out 在提交后的处理，包括增，删，改。如 	$common_submit_out="./test.php";代码内容如print_r($_POST);
 $common_button: 该变量控制是否先给出一个查询框，如果外部传入该变量值为1，说明具有查询功能，由外部传入查询条件$common_condition，第一次是变量传入，
 				调用common_mod=list模块，以后修改、增加、删除时用url变量传入(因为回调时$common_condition再次得到打开页面同名输入框的值，和最初值不一样了)，
 				调用common=list_condition模块
 $common_ext_deal: 外部传入该变量则说明需要外部处理,仍然使用本页的<增加><修改>,结束后后回调时调用$mod==ext_deal,
 $common_titlecolor: 列表标题背景色
 $common_linecolor: 详细行背景色
 $common_alterlinecolor: 交替详细行背景色
 $common_condition_linecolor: array() 根据某个字段条件设定该行背景色 采用数组，支持多条件，与common_condition_linecolor_col or配对使用
 $common_condition_linecolor_color: 根据某个字段条件设定该行背景色 array()
 $common_js_date: 是否启动默认调用日期时间控件，默认调用true。数据库字段为date启用日期，为datetime启用日期时间，调用控件路径在./_common下
 $common_meg:自定义显示信息 位置在“--显示记录--”后
 $common_footer:页面底部显示内容
 $common_attach_<字段名>: 0为默认，1为该字段保存附件，将保存16位字长的唯一编码;该功能需要调用 attachment.php;该功能                          需要$common_fields 中有定义，删除记录后，会调用attachment.php删除相应内容。
 $common_after_del:删除记录后的追加操作,可以传送的参数为#common_delid
 $common_lock_style:默认为 overflow:auto;width:100%;height:450px; 会影响总体长宽
 $common_title:页面标题
 $common_after_del:删除后跳转执行
//===========
 css和javascript的说明
//===========
	$listtable 标题表格样式
  CSS受以下几个自定义影响.table2 .button
  javascript  可能通过$common_ap_<字段名> 来调用js
  ./_common/common.js有本程序调用的javascript


其它注意:
  1、避免变量重复，外部程序，在调用本程序时，应避免用common打头的变量，以及不应用表中FIELD同名的变量。
  2、外部访问模式common_mod可为list,add,edit,需要注意的是,主程序要对这些变量做判断,因为它会回调主程序的,然后,再进入本程序
  3、与common.php主要不同在于，必须有primary_key,不再支持common的附件上传模式
*/
/*
 * ============================================================================
 * 版权所有 (C) 上海市电信有限公司西区局----客户响应建设中心
 * 公司地址：江苏路535号
 * ----------------------------------------------------------------------------
 * 请注明创建人和创建日期，如有修改，请注明修改人，修改日期和修改内容！
 * ============================================================================
 * <--创建信息-->
 * 创建人：
 * 创建日期：
 * ----------------------------------------------------------------------------
 * <--修改信息-->
 * 修改人：boydreaming
 * 修改日期：2008/1/16
 * 修改内容：fix $common_condition urlencode bug

 * 修改人：boydreaming
 * 修改日期：2008/1/7
 * 修改内容：fix $common_fields bug

 * 修改人：jinh
 * 修改日期：2008/1/3
 * 修改内容：增加自定义显示信息 未知在“--显示记录--”后 $common_meg

 * 修改人：boydreaming
 * 修改日期：2007/12
 * 修改内容：修改 $common_extprg_<字段名>,使得如果该字段有值的话，将不显示"按此"，以值替代.

 * 修改人：jinh
 * 修改日期：2008/1/3
 * 修改内容：增加自定义显示信息 未知在“--显示记录--”后$common_meg

 * ============================================================================
*/


//限制部份出错信息
error_reporting  (E_ERROR |E_PARSE);
if ((!isset($common_dbname))||(!isset($common_tbname))) {
	if (!isset($common_sql))
		die( "common_dbname|common_tbname|common_sql 未定义");
}

//======================内部类库定义=====================
//===================================================
class Common{
	public $dbname,$sql,$cols,$rows,$common_chsfield,$tbname,$mod,$perpage,$type,$curpage,$oldurl,$buttons,$str_add;
	public $fieldsinfo=array(),$extprg="",$mainindex="",$message="",$condition="",$search_field="",$searchkey="",$listcondition;

//连接数据库
	function dbconnect($dbname) {
		$link=@mysql_pconnect('localhost','remote','admin') or die("无法显示内容，连接服务器失败！请与管理员联系!".mysql_error());
		if (empty($dbname))
			$dbname="westmis";
		mysql_select_db($dbname) or die("数据库:$dbname 没找到！请与管理员联系!".mysql_errno());
    mysql_query("SET NAMES 'GBK'");
	}

//执行SQL语句
	public function executesql($sqlquerystring) {
		$result=@mysql_query($sqlquerystring) or die("无效语句! <BR> $sqlquerystring <BR>".mysql_error());
		return $result;
	}

//***转换英文字段为中文表示
	function getchsname($enname) {
		$enname=str_replace("`","",$enname);
		foreach($this->common_chsfield as $key=>$val) {
  		if ($key==$enname)
    		return $val;
		}
  	return $enname;
	}

	//判断是否中文字符
	function isgb($str)	{      
		if (strlen($str)>=2){      
  		$str=strtok($str,"");
  		for ($i=0;$i<strlen($str);$i++) {
  			if ((ord($str[$i])>161) && (ord($str[$i])<247))
  				return true;
  		}
    	return false;
  	}else{      
  		return false;   
  	}      
	} 
//=================================
//显示菜单按钮
//=================================
	function showmainbutton() {
		if (strpos($this->dbname,",")===false)
  		if (empty($this->condition))
  			$common_sqlstr="SELECT count(*) FROM $this->tbname";
  		else
  			$common_sqlstr="SELECT count(*) FROM $this->tbname WHERE $this->condition";
  	else
  		$common_sqlstr="SELECT count(*) ".substr($this->sql,strpos($this->sql,"FROM"));
  	
  	$result=$this->executesql($common_sqlstr);
 		$this->rows=mysql_result($result,0,0);
 		if ($this->mod=="search"){
 	  	$tmp="";
 		}else{
// 	  	$this->searchkey="";
 	  	$tmp=urlencode($this->condition);
 		}

 		echo "<table width=100% border=0 class=table2>";
  	echo "<tr><form name=common_searchfrm method=post action='$parent?common_mod=search&".$this->oldurl."'><td valign='middle'>".$this->buttons;
  	if (strpos($this->type,"list|")>0) {
  		echo "<BUTTON class=button onclick=window.location.href='$parent?common_mod=list&common_curpage=1&common_condition=".$this->listcondition.$this->oldurl."'>浏 览</BUTTON>\n";
		}
		$common_pages=ceil($this->rows/$this->perpage);
		if (empty($common_pages))
			$common_pages=1;
	//借$common_first为过滤变量，控制《增加》按钮的有效性
  	if ($this->extprg<>"")
  		if (strpos($this->extprg,"?")===false)
  			$common_first="onclick=window.location.href='".$this->extprg."?common_mod=add&common_id=$common_id'";
  		else
  			$common_first="onclick=window.location.href='".$this->extprg."&common_mod=add&common_id=$common_id'";
  	else
  		$common_first="onclick=window.location.href='$parent?common_mod=add&common_condition=$tmp".$this->oldurl."'";

  	if (strpos($this->type,"add|")>0)
  		echo "<BUTTON class=button $common_first>".$this->str_add."</BUTTON>\n";
  	if (strpos($this->type,"filter|")>0)
  		echo "<BUTTON class=button onclick=window.location.href='$parent?common_mod=filter&common_condition=$tmp".$this->oldurl."'>筛 选</BUTTON>\n";
  	if (strpos($this->type,"search|")>0){
  		$temp="";
  		if (!empty($this->search_field)){
  			$temparray=explode(",",$this->search_field);
  			for ($i=0;$i<count($temparray);$i++)
  				$temp.=$common->getchsname($temparray[$i]).",";
  			$temp=substr($temp,0,-1);
  		}
  		echo "<INPUT type='text' name=common_searchkey value=\"".$this->searchkey."\" title=$temp><INPUT TYPE=SUBMIT value='搜 索' class=button >\n";
  	}
  	if ($this->mainindex!="")
  		echo "<INPUT TYPE='BUTTON' name='exit' value='退 出' class=button onclick=window.location.href='$mainindex'>\n";

  	if(!empty($this->message)){ // add by jinh 080103
  		echo "<font color=red>(".$this->message.")</font>";
  	}
		
  	$temp="list";

		if (($this->mod=="list")||($this->mod=="filter")||($this->mod=="search"))
			$temp=$this->mod;
  	if (($common_pages>1)&&($this->curpage<>1))
			$common_first="<a href='$parent?common_mod=$temp&common_curpage=1&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."'  title='首页'><font face='Webdings'>9</font></a>";
		else
			$common_first="<font face='Webdings'>9</font>";
		if (($common_pages>1)&&($this->curpage<>$common_pages))
			$common_end="<a href='$parent?common_mod=$temp&common_curpage=$common_pages&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='尾页'><font face='Webdings'>:</font></a>";
		else
			$common_end="<font face='Webdings'>:</font>";

		if ($this->curpage<=1) {
			$this->curpage=1;
			$common_nexpage=$this->curpage+1;
 			if ($common_pages<=1)
				$common_next="<font face='Webdings'>8</font>";
			else
				$common_next="<a href='$parent?common_mod=$temp&common_curpage=$common_nexpage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='第 $common_nexpage 页'><font face='Webdings'>8</font></a>";
			$common_prev="<font face='Webdings'>7</font>";
		}else if (($this->curpage>1)&&($this->curpage< $common_pages)) {
		 	$common_nexpage=$this->curpage+1;
		 	$common_prepage=$this->curpage-1;
			$common_next="<a href='$parent?common_mod=$temp&common_curpage=$common_nexpage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='第 $common_nexpage 页'><font face='Webdings'>8</font></a>";
		 	$common_prev="<a href='$parent?common_mod=$temp&common_curpage=$common_prepage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='第 $common_prepage 页'><font face='Webdings'>7</font></a>";
		}else if ($this->curpage>=$common_pages) {
			$this->curpage=$common_pages;
		  $common_prepage=$this->curpage-1;
		 	$common_prev="<a href='$parent?common_mod=$temp&common_curpage=$common_prepage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='第 $common_prepage 页'><font face='Webdings'>7</font></a>";
		 	$common_next="<font face='Webdings'>8</font>";
		}
  
    echo "</td></form><td valign='middle'>";
    echo "页次:<b>$this->curpage/$common_pages</b> 页  每页<b>".$this->perpage."</b>  记录数<b>$this->rows</b>  $common_first $common_prev $common_next $common_end \n ";
    echo "</td><form name='skip'  method='post' action='$parent?common_mod=$temp&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."'>";
    echo "<td valign='middle'>";
    echo " 跳转到 第 <input type=text name='common_curpage' size=4> 页";
    echo " <input type='submit' name='ok' value='GO'>";
    echo "</td></FORM></tr></table>";
    echo "<HR color=red>";
	}
}


//======================函数部分=====================
//=================================
//采用扩展定义好的输入式样，主要针对数组关联
//=================================
function extinput($value,$type,$fact,$factarray,$rel_array,$appendstyle,$size) {
  if ($size>=40)
     $size=40;
	$common_array="common_ar_$value";
	if (is_array($factarray[0])) { //判断是否多维数组
		//生成定义数组
		$last="\n<script> var $common_array=new Array(".count($factarray).");\n ";
		for ($i=0;$i<count($factarray);$i++) {
			$last.=$common_array."[$i]=new Array(";
			for ($j=0;$j<count($factarray[$i]);$j++) {
				//二级多维数组的话，按逗号组成字符串
				if (is_array($factarray[$i][$j]))
					$tmp=implode(",",$factarray[$i][$j]);
				else
					$tmp=$factarray[$i][$j];
				$last.= '"'.$tmp.'"';
				if ($j<(count($factarray[$i])-1))
					$last.= ",";
			}
			$last.=");\n";
		}
	}else{
		//生成定义数组
		$last="\n<script> var $common_array=new Array(".count($factarray).");\n ";
		$i=0;
		while (list($arrkey,$arrval)=each($factarray)) {
			$last.=$common_array."[$i]=new Array(";
			$last.= '"'.$arrval.'"';
			$last.=");\n";
			$i++;
		}
	}
	if (is_array($rel_array[$value])) { //多维数组
		$tmp=implode(",",$rel_array[$value]);
		$last.=" var ".$value."_list=new poplistselect('".$value."','$tmp'); $value"."_list.init(1,$common_array);\n</script>\n";
		$last.="<INPUT name=$value VALUE='$fact' type=text  size=$size $appendstyle><button type=button class=cmbbutton onClick='getpopval($value,$value"."_list".")'></button>";
	}else{ //二维数组及一维
		$last.=" var ".$value."_list=new poplistselect('".$value."',''); \n $value"."_list.init(0,$common_array);\n</script>\n";
		$last.="<INPUT name=$value VALUE='$fact' type=text  size=$size $appendstyle><button type=button class=cmbbutton onClick='getpopval($value,$value"."_list".")'></button>";
	}
	return $last;
}



//=================================
//*生成与字段类型相应的HTML INPUT语句
//=================================
function getinput($value,$f_type,$fact,$max,$appendstyle,$appendjsdate) {
	global $common_js_date;
  if ($max==0) {//不知长度另行处理
		preg_match("/(\()(\d+)/i",$f_type,$max);
  if (empty($max)) {
  	if ($f_type=='date') {
      $max=10;
    }else if ($f_type=='datetime') {
      $max=20;
    }else if (!(strpos($f_type,'blob')===False))
    		$max=65535;
    	else
    		$max=10;
    }else
      $max=$max[2];
    }
    if ($max>=40)
      $size=40;
    else
      $size=$max;
    if ($appendstyle=="hidden") {
    	$last="<INPUT TYPE='hidden' NAME=$value value='$fact'>";
    }else{
     switch ($f_type):
       case (!(strpos($f_type,'text')===False))||(!(strpos($f_type,'blob')===False)):
    	 	 $last="<TEXTAREA  name=$value rows='4' cols='60' $appendstyle nowrap>$fact</TEXTAREA>";
    	 	 break;
    	 case (!(strpos($f_type,'int')===False)&&($max==1)):
      	 if ($fact==1)
    			 $last="<INPUT TYPE='CheckBox' $appendstyle name=$value size=$size value=1 checked>";
    		 else
    			 $last="<INPUT TYPE='CheckBox' $appendstyle name=$value size=$size value=1>";
    		 break;
    	 case (!(strpos($f_type,'real')===False)&&($max==5)):
    		 if ($fact==1)
    			 $last="<INPUT TYPE='CheckBox' $appendstyle name=$value size=$size value=1 checked>";
    		 else
    			 $last="<INPUT TYPE='CheckBox' $appendstyle name=$value size=$size value=1>";
    		 break;
    	case "date":
    	 	if ($common_js_date)
    	 		if ($appendstyle=="readonly")
    	 			$last="<input type=\"text\" name=\"$value\" value=\"$fact\" size=10 readonly/>";
    	 		else
    	 			$last="<input type=\"text\" name=\"$value\" class=\"Wdate\" value=\"$fact\" onfocus=\"WdatePicker({skin:'whyGreen' $appendjsdate})\" $appendstyle/>";
    	 	else
    	 		$last="<input type=\"text\" name=\"$value\" value=\"$fact\"  $appendstyle/>";
    	 	break;
    	case "datetime":
    	 	if ($common_js_date)
    	 		if ($appendstyle=="readonly")
    	 			$last="<input type=\"text\" name=\"$value\" readonly/>";
    	 		else
    	 			$last="<input type=\"text\" name=\"$value\" class=\"Wdate\" value=\"$fact\" onFocus=\"WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})\" $appendstyle/>";
    	 	else
    	 		$last="<input type=\"text\" name=\"$value\" value=\"$fact\"  $appendstyle/>";
    	 	break;
    	default:
    		$fact=stripslashes($fact);
    		$fact=htmlspecialchars($fact);
    		$last="<INPUT TYPE=\"TEXT\" name=$value size=$size value=\"$fact\" maxlength=$max $appendstyle>";
    		break;
			endswitch;
	  }
    return $last;
}


//======================主程序部分=====================
//=================================
// === 入口参数处理(先处理的部分)
//=================================
$common=new Common;
if (strpos($common->dbname,",")===false)
	$common->dbconnect($common_dbname);
$common->common_chsfield=$common_chsfield;
$common->tbname=$common_tbname;
$common->mod=$common_mod;
$common->extprg=$common_extprg;
$common->mainindex=$mainindex;
$common->buttons=$common_buttons;
$common->message=$common_meg;
$common->search_field=$common_search_field;

//判断是否预定义了SQL命令
if (isset($common_sql)){
  //去除多余的空格
	while (strpos($common_sql,", ")>0) {
		$common_sql=str_replace(", ",",",$common_sql);
	}
	$common_sql=str_replace(" select "," SELECT ",$common_sql);
	$common_sql=str_replace(" from "," FROM ",$common_sql);
	$common_sql=str_replace(" where "," WHERE ",$common_sql);
	$common_sql=str_replace(" join "," JOIN ",$common_sql);
	$common_sql=str_replace(" left "," LEFT ",$common_sql);
	$common_sql=str_replace(" right "," RIGHT ",$common_sql);
	$common_sql=str_replace(" on "," ON ",$common_sql);
	$common_sql=str_replace("`","",$common_sql);
	if (strpos($common_sql,"WHERE")===false)
		echo "有sql语句无WHERE，不符合定义！";
	if (strpos($common_sql,"JOIN")===false)
		$common->dbname=substr($common_sql,strpos($common_sql,"FROM")+4,strpos($common_sql,"WHERE")-strpos($common_sql,"FROM")-4);
	else{
		if (strpos($common_sql,"LEFT")===false)
			$common->dbname=substr($common_sql,strpos($common_sql,"FROM")+4,strpos($common_sql,"RIGHT")-strpos($common_sql,"FROM")-4);
		else
			$common->dbname=substr($common_sql,strpos($common_sql,"FROM")+4,strpos($common_sql,"LEFT")-strpos($common_sql,"FROM")-4);
		$common->dbname= trim($common->dbname).",".trim(substr($common_sql,strpos($common_sql,"JOIN")+4,strpos($common_sql,"ON")-strpos($common_sql,"JOIN")-4));
	}
	$common->sql=$common_sql;
}else{
  if (!isset($common_title))
    $common_title=$_REQUEST["common_title"];
	if (!empty($common_title))
		echo "<title>$common_title</title>";
	$common->dbname=$common_dbname;
}

if (!isset($listtable)) {
  $listtable="<style> .listtable {BORDER-TOP-WIDTH: 0px;width:100%;height:100%;}</style>";
}
echo $listtable;

$parent=$_SERVER['PHP_SELF'];
$parentdir="/westmis";

$common_id=$_REQUEST["common_id"];

if (empty($common_perpage)) 
	$common_perpage=20;
$common->perpage=$common_perpage;

$common_curpage=$_REQUEST['common_curpage'];
if (empty($common_curpage))
	$common_curpage=1;
$common->curpage=$common_curpage;
$common_starpage=($common->curpage-1)*$common->perpage;

//原先URL后跟的参数补入
$common_query=$_SERVER['QUERY_STRING'];
$common_query=split("&",$common_query);

$temp_query="";
for ($i=0;$i<sizeof($common_query);$i++) {
	if ((substr($common_query[$i],0,7)!='common_')&&(!empty($common_query[$i]))) {
		$temp_query=$temp_query.'&'.$common_query[$i];
	}
}

//去掉未尾&符号
if (substr($temp_query,-1)=="&")
	$temp_query=substr($temp_query,0,-1);

$common->oldurl=$temp_query;

//默认有添加，删除，修改功能
if (empty($common_type)) 
	$common_type="|add|del|edit|list|filter|search|";
$common->type=$common_type;
if (empty($common_str_edit)) 
	$common_str_edit="修改";
if (empty($common_str_add))
	$common_str_add="增 加";
$common->str_add=$common_str_add;

//多表SQL不支持删除和添加
if (!strpos($common->dbname,",")===false){
	$common_type=str_replace("add|","",$common_type);
	$common_type=str_replace("del|","",$common_type);
}

//javascript  预调用部分
if (empty($common_ap_commonfrm))
	$common_ap_commonfrm=" onSubmit='submitonce(this)'";

if (!isset($common_js_date)){
	echo "<SCRIPT language=JavaScript src='/westmis/_common/WdatePicker.js'></SCRIPT>\n";
	echo "<SCRIPT language=JavaScript src='/westmis/_common/submitonce.js'></SCRIPT>\n";	
	$common_js_date=true;
}

//====

// 如果有过滤值传过来
// 如果有预定义条件，认为是“浏览”按钮条件。

//if (isset($common_condition)) {
//	$common_condition=stripslashes($common_condition);
//	$common->listcondition=urlencode($common_condition);
//}

if (!empty($_REQUEST['common_condition'])) {
	$common_condition=$_REQUEST['common_condition'];
	$common_condition=stripslashes($common_condition);
	if (!(strpos($common_condition,"%")===false))
		$common_condition=urldecode($common_condition);
}
if (!empty($common_condition)) {
  $common_condition=str_replace("and","AND",$common_condition);
  if (substr($common_condition,1,3)=="AND")
    $common_condition=str_replace("AND","",$common_condition);
  $common_condition=str_replace("order","ORDER",$common_condition);
}
$common->condition=$common_condition;

//搜索关键字
$common_searchkey=$_REQUEST["common_searchkey"];
$common->searchkey=$common_searchkey;

if (isset($common_fields))
	$common_fields=stripslashes($common_fields);
else
	$common_fields='*';

$common_mod=$_GET["common_mod"];
$common_delid=$_POST["common_delid"];
$common_sqlstr=$_POST["common_sqlstr"];

if (empty($common_mod)) {
	$common_mod="list";
}
$common->mod=$common_mod;

//==识别primary_key
if (strpos($common->dbname,",")===false)
	$result=$common->executesql("select $common_fields from $common_tbname where 1=2") or die ("查询失败:".mysql_error());
else
	$result=$common->executesql($common_sql." and 1=2") or die ("查询失败:".mysql_error());
$common->cols=mysql_num_fields($result);
$common_index="";
$common_array=0;
$common_attachment=0;
$tmp="";
for ($i=0;$i< $common->cols;$i++) {
	$common->fieldsinfo[$i]=mysql_fetch_field($result,$i);
	$value=$common->fieldsinfo[$i]->name;
	if ($value=='key') {//保留字加``
		$value="`key`";
		$common->fieldsinfo[$i]->name=$value;
	}
	if ($common->fieldsinfo[$i]->type=="string")
		$common->fieldsinfo[$i]->maxlength=round(mysql_field_len($result,$i)/2);
	else
		$common->fieldsinfo[$i]->maxlength=mysql_field_len($result,$i);

	if (!(strpos(mysql_field_flags($result,$i),"primary_key")===false))
		if (strpos($common->dbname,",")===false)
			$common_index=$value;
		else
			$common_index=$common->fieldsinfo[$i]->table.".$value";
	$tmp1.=$value.",";
  //预处理关联数组部分
  $tmp="common_ar_$value";
  $tmp=$$tmp;
  if (is_array($tmp)) {
  	$common_array=1;
  }
  $tmp="common_attach_$value";
  if ($$tmp){
  	$common_attachment=1;
  }
}

if ((empty($common_fields))||($common_fields=="*"))
	$common_fields=substr($tmp1,0,-1);

if (empty($common_index))
	die("没有找到primary_key字段.如果采用自定义的多表联合SQL语句，应该一个primary_key在FIELDS中!");

if ($common_array) {
PRINT <<<EOT
	<style>.cmbbutton {
		background-image:url(../../images/cmb.gif);width:12px;height:20px;BORDER-RIGHT: #b5c7e7 0px solid;	BORDER-TOP: #b5c7e7 0px solid;BORDER-LEFT: #b5c7e7 0px solid;	COLOR: #000000;	BORDER-BOTTOM: #b5c7e7 0px solid;	background-repeat: no-repeat;	background-position: left;cursor: hand;
		}
	</style>
	<SCRIPT language=JavaScript src='/westmis/_common/common.js'></SCRIPT>
  <SCRIPT language=JavaScript src='/plugin/tablemaker/js/jquery.js'></SCRIPT>
EOT;
}

if (!isset($common_lock_style))
	$common_lock_style="overflow:auto;width:100%;height:450px;";
//颜色设置
if (empty($common_titlecolor))
	$common_titlecolor="#b5c7e7";

if (empty($common_alterlinecolor))
	$common_alterlinecolor="#D8D8D8";
// ===== 结束入口部分


//=================================
// ---处理删除操作
//=================================
  if ($common_mod=='postdel') {
  	if ($common_delid<>'') {
  		$tmp="";
  		for ($i=0;$i<sizeof($common_delid);$i++) {
				if (is_int($common_delid[$i])){
					$tmp.=$common_delid[$i].",";
				}else{
					$tmp.="'$common_delid[$i]',";
				}
				//如果有附件要处理附件表
				if ($common_attachment) {
					$result=$common->executesql("select * from $common_tbname where $common_index=".$common_delid[$i]);
					$cols=mysql_num_fields($result);
					$c=0;
					echo "删除相关附件 ";
					while ($row=mysql_fetch_array($result)) {
						for ($j=0;$j<$cols;$j++) {
							$fieldname=mysql_field_name($result,$i);
							$tmpc="common_attach_$fieldname";
							if ($$tmpc) {
								$value=$row[$fieldname];
								echo ".";
								$common->executesql("delete from westmis.attachments where id='$value'");
							}
						}
						$c++;
					}
					echo "<BR>";
				}
  		}
  		$common_delid=substr($tmp,0,-1);
	 		$common_sqlstr="delete from $common_tbname where $common_index in ($common_delid)";
	  	$common->executesql($common_sqlstr);
   		if ($common_submit_out) {
   	  		include($common_submit_out);
   		}
  	}
  	if ($common_condition!=''){
  	  $common_condition=urlencode($common_condition);
  		$tmp="$parent?common_mod=list&common_curpage=$common_curpage&common_condition=$common_condition".$common->oldurl;
  	}else{
  		if (empty($common->searchkey))
  			$tmp="$parent?common_mod=list&common_curpage=$common_curpage".$common->oldurl;
  		else
  			$tmp="$parent?common_mod=search&common_curpage=$common_curpage&common_searchkey=".$common->searchkey.$common->oldurl;
  	}
  	if ($common_after_del) {
  		$common_after_del=str_replace("#common_delid",$common_delid,$common_after_del);
  		echo '<script>window.location="'.$common_after_del.'";</script>';
			exit;
  	}
  	echo '<script>window.location="'.$tmp.'";</script>';
 }


//=================================
// ---处理编辑的记录
//=================================
  if ($common_mod=='postedit') {
  	$common_sqlstr=urldecode($common_sqlstr);

 	if (strpos($common_sqlstr,'WHERE')===false)
    		exit("SQL 语句缺少WHERE,不可执行！");
 	$wheresql=substr($common_sqlstr, strpos($common_sqlstr,'WHERE'),strlen($common_sqlstr)-strpos($common_sqlstr,'WHERE')+1);
	if (strpos($common->dbname,",")===false)
		$common_sqlstr="UPDATE $common_tbname SET";
	else
	 	$common_sqlstr="UPDATE ".$common->dbname." SET";
  for ($i=0;$i< $common->cols;$i++) {
    $fieldname=$common->fieldsinfo[$i]->name;
    $value=str_replace("`","",$fieldname);
		if (!(strpos($_POST[$value],chr(92))===false)) {  //如果不存在"\"
			  $_POST[$fieldname]=addslashes($_POST[$fieldname]);
		  }
		  if (!empty($fieldname)){
				if (strpos($common->dbname,",")===false)
			  	$common_sqlstr=$common_sqlstr." $fieldname='".$_POST[$value]."',";
				else{
			  	if ($fieldname==$common_index)
			  		$wheresql.=" AND $common_index=".$_POST[$common_index];
			  	else
			  		$common_sqlstr=$common_sqlstr." ".$common->fieldsinfo[$i]->table.".$fieldname='".$_POST[$value]."',";
				}
			}
  }
    $common_sqlstr=substr($common_sqlstr,0,-1).' '.$wheresql;
    if ($common->executesql($common_sqlstr)>0) {
    	echo "修改成功 ";
   		if ($common_submit_out) {
   	  	include($common_submit_out);
   		}
    	if ($common_ext_deal==1) {
    		if ($common_condition!='')
    			$tmp="$parent?common_id=$common_id&commom_curpage=$common_curpage&common_condition=".urlencode($common_condition)."&mod=ext_deal";
				else
					$tmp="$parent?common_id=$common_id&commom_curpage=$common_curpage&mod=ext_deal";
    	}else {
				if ($common_condition!='')
    			$tmp="$parent?common_mod=list&common_curpage=$common_curpage&common_condition=".urlencode($common_condition)."$temp_query";
    		else{
    			if (empty($common->searchkey))
    		  	$tmp="$parent?common_mod=list&common_curpage=$common_curpage&common_condition=$temp_query";
    		  else
    		  	$tmp="$parent?common_mod=search&common_curpage=$common_curpage&common_searchkey=".$common->searchkey.$temp_query;
    		}
    	}
    	echo '<script>window.location="'.$tmp.'";</script>';
   	}
  }

//=================================
// --编辑记录界面模式
//=================================
  if ($common_mod=="edit") {
    $common->showmainbutton();
    echo "\n<FORM name=commonfrm method='post' enctype='multipart/form-data' action='$parent?common_mod=postedit$temp_query&common_curpage=$common_curpage' $common_ap_commonfrm>\n";
    echo "<TABLE WIDTH='100%' BORDER='1'>";
    if (strpos($common->dbname,",")===false)
    	$common_sqlstr="select $common_fields from $common_tbname WHERE $common_index='$common_id'";
    else
    	$common_sqlstr=$common->sql." AND $common_index='$common_id'";
	  $result=$common->executesql($common_sqlstr);
    if (mysql_num_rows($result)==0)
    	exit;

    for ($i=0;$i< $common->cols;$i++) {
    	$value=$common->fieldsinfo[$i]->name;
      $chsvalue=$common->getchsname($value);
      $fact=mysql_result($result,0,$i);
			$factarray="common_ar_$value";
			$factarray=$$factarray;
			$appendstyle="common_ap_$value";
			$appendstyle=$$appendstyle;

    	$appendjsdate="common_".$value."_jsdateappend";
    	$appendjsdate=$$appendjsdate;

			if (is_array($factarray)) {  //采用单选输入框
				$rel_array="common_rel_$value";
				$rel_array=$$rel_array;
				$inputfield=extinput($value,1,$fact,$factarray,$rel_array,$appendstyle,$common->fieldsinfo[$i]->maxlength);
			}else{
      	$inputfield=getinput($value,$common->fieldsinfo[$i]->type,$fact,$common->fieldsinfo[$i]->maxlength,$appendstyle,$appendjsdate);
			}
			$tmp="common_attach_$value";
			if ($$tmp==1) {
				$inputfield="<INPUT TYPE=hidden NAME=\"$value\" value=\"$fact\"><iframe allowTransparency=true height=80 width=308 SCROLLING=AUTO FRAMEBORDER=0 src=\"$parentdir/attachment.php?attachid=$fact\" ></iframe>";
			}
      if ($inputfield<>"") {
    		if ($i/2==floor($i/2))
    			echo "<TR BGCOLOR=$common_linecolor>";
    		else
    			echo "<TR BGCOLOR=$common_alterlinecolor>";

      	if ($appendstyle=="hidden") {
      		echo $inputfield;
      	}else{
        	echo "<TD>$chsvalue</TD>\n";
        	echo "<TD>$inputfield</TD></TR>\n";
      	}
      }
     }
     echo "<INPUT TYPE='HIDDEN' name='common_searchkey' value='".$common->searchkey."'>";
     echo "<INPUT TYPE='HIDDEN' name='common_condition' value='".urlencode($common_condition)."'>";
     echo "<INPUT TYPE='HIDDEN' name='common_id' value='".$common_id."'>";
     echo "<INPUT TYPE='HIDDEN' name='common_sqlstr' value='".urlencode($common_sqlstr)."'>";
     echo "<TR><TD colspan=2><INPUT TYPE='SUBMIT' name='add' value='确认'><TD></TR></TABLE></FORM>\n";
  }

//=================================
// ---处理增加的记录
//=================================
  if ($common_mod=='postadd') {
    $sqlquery="INSERT INTO $common_tbname ($common_fields) VALUES (";
    $tmparray=explode(",",$common_fields);
    for ($i=0;$i<sizeof($tmparray);$i++) {
    	$value=$tmparray[$i];
    	$value=str_replace("`","",$value);
      if (empty($_GET[$value]))
        $sqlquery=$sqlquery.'"'.$_POST[$value].'",';
      else
        $sqlquery=$sqlquery.'"'.$_GET[$value].'",';
    	$value=mysql_result($result,$i,'field');
    }
    $sqlquery=substr($sqlquery,0,-1).')';

    if ($common->executesql($sqlquery)>0) {
        	echo "添加成功";
   		if ($common_submit_out) {
   	  		include($common_submit_out);
   		}
    		if ($common_ext_deal==1) {
    			echo "<script>window.location='$parent?common_id=$common_id&common_condition=".urlencode($common_condition)."&mod=ext_deal'</script>";
    			exit;
    		}
	else {
			if ($common_condition!='')
    				echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';
    			else
    				echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.$temp_query.'";</script>';
    		}
	}
  }

//=================================
// ---增加记录界面模式
//=================================
  if ($common_mod=="add") {
    $common->showmainbutton();

		echo "\n<FORM method='post' name='commonfrm' enctype='multipart/form-data' action='$parent?common_mod=postadd$temp_query&common_condition=".urlencode($common_condition)."' $common_ap_commonfrm>\n";
    echo "<TABLE WIDTH='100%' BORDER='1'>";
    for ($i=0;$i< $common->cols;$i++){
    	$value=$common->fieldsinfo[$i]->name;
    	$chsvalue=$common->getchsname($value);
  		$factarray="common_ar_$value";
  		$factarray=$$factarray;
  		$appendstyle="common_ap_$value";
  		$appendstyle=$$appendstyle;
  		$fact="common_default_$value";
  		$fact=$$fact;
  		$tmp="common_extprg_".$value; //如果这个字段存在扩展调用外部程序，则隐藏
  		if (isset($$tmp))
  			$appendstyle="hidden";
  		if (is_array($factarray)) {  //采用单选输入框
  			$rel_array="common_rel_$value";
  			$rel_array=$$rel_array;
  			$inputfield=extinput($value,1,$fact,$factarray,$rel_array,$appendstyle,$common->fieldsinfo[$i]->maxlength);
  		}else{
        $inputfield=getinput($value,$common->fieldsinfo[$i]->type,$fact,$common->fieldsinfo[$i]->maxlength,$appendstyle);
  		}
			$tmp="common_attach_$value";
			if ($$tmp==1) {
				$fact=uniqid("xq");
				$inputfield="<INPUT TYPE=hidden NAME=\"$value\" value=\"$fact\"><iframe allowTransparency=true height=80 width=308 SCROLLING=AUTO FRAMEBORDER=0 src=\"$parentdir/attachment.php?attachid=$fact\" ></iframe>";
			}
      if ($inputfield<>'') {
      	if ($i/2==floor($i/2))
      		echo "<TR BGCOLOR=$common_linecolor>";
      	else
      		echo "<TR BGCOLOR=$common_alterlinecolor>";
        if ($appendstyle=="hidden") {
        	echo $inputfield;
        }else{
           echo "<TD>$chsvalue</TD>\n";
           echo "<TD>$inputfield</TD></TR>\n";
         }
       }
    }
    echo "<TR><TD><INPUT TYPE='SUBMIT' name='add' value='确认'></TD>";
    echo "<TD><button class=button onclick='javascript:history.go(-1)'>返回</button></TD></TR></TABLE></FORM>\n";
  }

//=================================
// ---列表显示界面模式(默认模式)
//=================================
  if (($common_mod=='list')||($common_mod=="postfilter")||($common_mod=="search")) {
  	if ($common_mod=="postfilter"){
  		$tmps="";
    	for ($i=0;$i< $common->cols;$i++) {
    		$value=$common->fieldsinfo[$i]->name;
    		$appendstyle="common_ap_$value";
			  $appendstyle=$$appendstyle;
				if ($appendstyle<>"hidden")
    			if ($_POST[$value]<>"_common_all") {
    				$value=str_replace("`","",$value);
    				$tmps.=$value."='".$_POST[$value]."' AND ";
    			}
    	}
    	$common_condition=substr($tmps,0,strrpos($tmps,"AND"));
    	if (!empty($common->condition))
    		$common_condition.="AND ".$common->condition;
    	$ext_filter=1;
  	}
  	if ($common_mod=="search") {
  		$tmps="";
  		if (!empty($common->searchkey)){
  			if (empty($common->search_field)){
    				for ($i=0;$i< $common->cols;$i++) {
    					$value=$common->fieldsinfo[$i]->name;
    					if (($common->fieldsinfo[$i]->type=='date')||($common->fieldsinfo[$i]->type=='datetime')||($common->fieldsinfo[$i]->type=='time')) {
								if (!$common->isgb($common->searchkey)) {
									$tmps.=$value." like \"%".$common->searchkey."%\" OR ";
								}
    					}else{
    						$tmps.=$value." like \"%".$common->searchkey."%\" OR ";
    					}
    				}
    			}else{
    				$common->search_field=explode(",",$common->search_field);
    				for ($i=0;$i<count($common->search_field);$i++) {
    					$tmps.=$common->search_field[$i]." like \"%".$common->searchkey."%\" OR ";
    				}
    			}
    		}
    		$common_condition=substr($tmps,0,strrpos($tmps,"OR"));
    		$ext_filter=1;
  	}
  	$common->condition=$common_condition;
    $common->showmainbutton();
    $common_fixhead="\"position: relative;top: expression(this.offsetParent.scrollTop);\"";
    $common_fixtitlecol="\"position:relative;left:expression(this.parentElement.offsetParent.scrollLeft);\"";
    $common_fixtitlecol="";
    $common_fixdatacol="\"position:relative;left:expression(this.parentElement.offsetParent.parentElement.scrollLeft);\"";
    $common_fixdatacol="";

    //构成sql语句
    if (strpos($common->dbname,",")===false){
    	if ((isset($common_sqlstr))&&($common_sqlstr!='')) {
    		//过滤反义字符
    		$common_sqlstr=stripslashes($common_sqlstr);
      	$common_sqlstr=htmlspecialchars(urldecode($common_sqlstr));
    	}else{
      	if (($ext_filter==1)&&(ltrim(rtrim($common_condition))<>'')&&(ltrim(rtrim($common_sort))<>'')){
        	$common_sqlstr="select $common_fields from $common_tbname WHERE $common_condition ORDER BY $common_sort limit $common_starpage,$common_perpage";
      	}else if (($ext_filter==1) && (ltrim(rtrim($common_condition))<>'')){
       		$common_sqlstr="select $common_fields from $common_tbname WHERE $common_condition limit $common_starpage,$common_perpage";
      	}else if (($ext_filter==1) && (ltrim(rtrim($common_sort))<>'')){
        	$common_sqlstr="select $common_fields from $common_tbname ORDER BY $common_sort limit $common_starpage,$common_perpage";
      	}else{
        		$common_sqlstr="select $common_fields from $common_tbname limit $common_starpage,$common_perpage";
      	}
    	}
    }else{
    	$common_sqlstr=$common->sql." limit $common_starpage,$common_perpage";
    }

    $result=$common->executesql($common_sqlstr);
    echo "\n<div style=\"$common_lock_style\"><TABLE border=1 class=listtable>\n";
    echo "<form name='common_frm' method=post action='$parent?common_mod=postdel&common_id=$common_id&common_curpage=$common_curpage&common_searchkey=".$common->searchkey."$temp_query'>\n";
    if ($common_mod<>"search")
    	echo "<input type=hidden name=common_condition value=\"".urlencode($common_condition)."\">";
    echo "<TR style=$common_fixhead BGCOLOR=$common_titlecolor>";
    if (strpos($common_type,"del|")>0)
    	echo "<TD style=$common_fixtitlecol><input type=button style='width:52px' onclick=\"{ if (confirm('确定删除记录吗?')) {this.document.common_frm.submit();return true;}return false;}\" value=\"删除\"></TD>";
    else
    	echo "<TD>&nbsp;</TD>";
     //字段显示并翻译为中文
    for ($i=0;$i<$common->cols;$i++) {
    	$value=$common->fieldsinfo[$i]->name;
			$appendstyle="common_ap_$value";
			$appendstyle=$$appendstyle;
    	if ((!preg_match("/_data_/i",$value))&&($appendstyle<>"hidden")) {
      	$value=$common->getchsname($value);
      	echo "<TD align='center'><B>$value</B></TD>";
    	}
    }
    echo "</TR>";
    //显示记录内容
    $rows=mysql_num_rows($result);
    for ($i=0;$i<$rows;$i++) {
    	if (sizeof($common_condition_linecolor)) {
    		$id=mysql_result($result,$i,$common_index);
    		for ($j=0;$j< sizeof($common_condition_linecolor);$j++) {
    			$temp="select count(*) from $common_tbname WHERE ".$common_condition_linecolor[$j]." AND $common_index=$id";
    			$temp_query=$common->executesql($temp);
    			if (mysql_result($temp_query,0,0)>0)
        		echo "<TR BGCOLOR=\"".$common_condition_linecolor_color[$j]."\">";
        }
    	}else{
    		if ($i/2==floor($i/2))
    			echo "<TR BGCOLOR=$common_linecolor>";
    		else
    			echo "<TR BGCOLOR=$common_alterlinecolor>";
    	}

      $wheresql=" WHERE ";
      $htmlstring='';
      $common_id="";

      for ($j=0;$j< $common->cols;$j++) {
      	$fieldname=$common->fieldsinfo[$j]->name;
        $value=mysql_result($result,$i,$j);
        //保存索引值,如果过滤的字段里没有索引值可能会导致找不到索引值
        if (strpos($common->dbname,",")===false){
      		if ($fieldname==$common_index)
      			$common_id=$value;
      	}else{
      		if (($common->fieldsinfo[$j]->table.".".$fieldname)==$common_index){
      			$common_id=$value;
      		}
      	}
				$appendstyle="common_ap_$fieldname";
				$appendstyle=$$appendstyle;
        //不处理appendstyle=hidden
        if ($appendstyle<>"hidden") {
					if (($value==null)||(trim($value)==""))
						$value="&nbsp;";
					else
						$value=stripslashes($value);
					//外部调用处理
      		if (!(empty($common_extprg))){
      			if (strpos($common_extprg,"?")===false)
      				$value="<a href='$common_extprg?common_mod=list&common_id=$common_id' title='(显示模式)' > $value </a>";
      			else
      				$value="<a href='$common_extprg&common_mod=list&common_id=$common_id' title='(显示模式)' > $value </a>";
      		}
      		$tmp="common_extprg_".$fieldname; //是否存在自定义字段关联
      		$tmp1="common_extprg_".$fieldname."_button"; //是否存在自定义字段提示按钮
      		if (isset($$tmp1))
      			$tmp1=$$tmp1;
      		elseif ((empty($value))||($value=="&nbsp;"))
      			$tmp1="按此";
      		else
      			$tmp1=$value;

      		if (isset($$tmp)) {
      			if (strpos($tmp1,"#common")>0) {
      				$tmp1=str_replace("#common_id",$common_id,$tmp1);
      				$value=$tmp1;
      			}else{
      				$value="<div align=center><button class=button onclick=window.location='".$$tmp."&common_mod=list&common_id=$common_id'>$tmp1</button></div>";
      			}
      		}
      		$tmp="common_link_".$fieldname;
      		if (isset($$tmp))
      			$value="<a href='".$$tmp."&$fieldname=$value' target=_blank>".$value."</a>";

          //附件处理
          $tmp="common_attach_$fieldname";
          if (($$tmp)&&($value<>"&nbsp;")) {
          	$value="<iframe allowTransparency=true height=30 width=308 SCROLLING=AUTO FRAMEBORDER=0 src=\"$parentdir/attachment.php?attachid=$value&action=list\"></iframe>";
          }

          $htmlstring.="<TD>$value</TD>";
        }
      }
      echo "<TD style=$common_fixdatacol>";
      if ($num>0) { //有记录情况无common_id异常
      	if ((!isset($common_id))||($common_id==""))
      		die("找不到索引值！");
      }
      if (strpos($common_type,"del|")>0)
        	echo "<input type=CheckBox name=common_delid[] value=$common_id>";
      if (strpos($common_type,"edit|")>0) {
  			if (empty($common_extprg)){ //如果存在外部程序调用外部程序
  				if ($common_mod=="search")
  					$tmp="'$parent?common_mod=edit&common_id=$common_id&common_curpage=$common_curpage$temp_query&common_searchkey=".$common->searchkey."'";
  				else
  					$tmp="'$parent?common_mod=edit&common_id=$common_id&common_curpage=$common_curpage$temp_query&common_condition=".urlencode($common_condition)."'";
  			}else{
  				if  (strpos($common_extprg,"?")===false)
  					$tmp="'$common_extprg?common_mod=edit&common_id=$common_id' target=_blank";
  				else
  					$tmp="'$common_extprg&common_mod=edit&common_id=$common_id' target=_blank";
  			}
  			echo "<a href=$tmp>$common_str_edit</a>\n";
			}else{
				echo "&nbsp;";
			}
     	echo "</TD>$htmlstring</TR>\n";
    }
    echo "</form></TABLE></div>\n";
  }

//=================================
// ---筛选界面模式(默认模式)
//=================================
  if ($common_mod=='filter') {
    $common->showmainbutton();
    if (!$common->rows) {
    	exit("无数据，不需要筛选！");
    }

    echo "\n<TABLE width=100% BORDER='1' width=100%><form name='common_frm' method=post action='$parent?common_mod=postfilter&common_id=$common_id&common_curpage=$common_curpage$temp_query&common_condition=".urlencode($common_condition)."'>";
    if (strpos($common_condition,"ORDER")>0) {
    	$common_temp=substr($common_condition,0,strpos($common_condition,"ORDER")-1);
    }
    echo "<TR><TH>列名</TH><TH>内容</TH><TH align=right><input name=submit type=submit value='执行筛选'></TH></TR>";
    for ($i=0;$i<$common->cols;$i++) {
    	$fldname=$common->fieldsinfo[$i]->name;
    	$appendstyle="common_ap_$fldname";
			$appendstyle=$$appendstyle;
			if ($appendstyle<>"hidden"){
    		$chsvalue=$common->getchsname($fldname);
    		echo "<TR><TD>$chsvalue</TD><TD colspan=2><select name=$fldname><option value='_common_all'>----</option>";
    		if (strpos($common->dbname,",")===false){    			
					$common_sqlstr="SELECT $fldname FROM $common_tbname WHERE $common_temp GROUP BY $fldname";
				}else{
					$common_sqlstr=$common->sql;
					$common_sqlstr="SELECT $fldname FROM ".substr($common_sqlstr,strpos($common_sqlstr,"FROM")+4);
				}
    		$result=$common->executesql($common_sqlstr);
    		for ($j=0;$j<mysql_num_rows($result);$j++){
    			$value=mysql_result($result,$j,0);
    			echo "<option value=\"$value\">$value</option>";
    		}
    		echo "</select></TD></TR>\n";
    	}
    }
    echo "<TR><TH colspan=3 align=right>(多个条件为AND关系)<input name=submit type=submit value='执行筛选'></TH></TR></form>";
    echo "</TABLE>";
	}


if (!empty($common_footer))
	echo $common_footer;
?>
