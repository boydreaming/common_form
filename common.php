<?
/*
 使用说明 
 2005年5月  last modify boydreaming
 调用方法 ：
 require ("../common.php");
 
//===========
 外部程序必须定义的变量：
//===========
 $common_mod: 方式(list,add,edit)
 $common_dbname   数据库名
 $common_tbname 表名
 $mainindex 返回的主程序
 
//===========
 外部程序可定义的变量：
//===========
 $common_type: 该变量决定是否具有增加、删除或是修改功能；外部定义该变量值为query时，只能浏览，否则可以增加、删除或者修改
 $common_chsfield : 字段中英对照
                   如:$common_chsfield=Array("case_info_id_a"=>"处理单编号", "customername"=>"户名")
 $ext_filter:是否采用外部条件,与$common_condition配对
 $common_condition: 条件变量 sql 语句 where后的字符串
 $common_sort: 排序字段名称
 $common_ar_<字段名>  外部输入式样,需数组类型. 用于生成如单选输入框的式样
 $common_rel_<字段名>  如果$common_ar_<字段名>是多维数组，将生成关联数组，例如：$common_rel_papertype1=array("papertype1"=>"papertype2");　表示
 papertype1,papertype2形成关联，则papertype1决定papertype2.
 $common_perpage  每页多少记录数
 $common_ap_<字段名> 追加样式，如" disabled"; 可使相应输入框为灰
 
//===========
 外部css或javascript可定义
//===========
  CSS可以外部定义如下几个：.table2 .button
  javascript 调用了function submitonce(theform)

其它注意:
  1、避免变量重复，外部程序，在调用本程序时，应避免用common打头的变量，以及不应用表中FIELD同名的变量。
  2、不能向该模块传送access,common_dbname变量，否则会被认为恶意调用
  5、外部访问模式common_mod可为list,add,edit,需要注意的是,主程序要对这些变量做判断,因为它会回调主程序的,然后,再进入本程序

*/
//限制部份出错信息
error_reporting  (E_ERROR |E_PARSE);
if ((!empty($_REQUEST['access']))||(!empty($_REQUEST['common_dbname']))) {
	die( "想干嘛？");
}
if ((!isset($common_dbname))||(!isset($common_tbname))) {
	die( "缺少参数!");
}

/*
//连接数据库
  function dbconnect($common_dbname="westmis"){
    if (!mysql_connect('localhost','admin','admin')) {
       echo mysql_errno().":".mysql_error()."<BR>";
       die("无法显示内容，连接服务器失败！请与管理员联系!");
    }else{
    	if (!mysql_select_db($common_dbname)) {
      	echo mysql_errno().":".mysql_error()."<BR>";
        die("$common_dbname 没找到！请与管理员联系!");
      }
    }
  }

//执行SQL语句
	function executesql($sqlquerystring) {
		$result=mysql_query($sqlquerystring);
		if (!$result) {
			echo mysql_errno() . ": " . mysql_error(). "<BR>"; 
			die("无效语句! $sqlquerystring <BR>");
		}
		return $result;
	}
*/


//======================函数部分=====================
//=================================
//***转换英文字段为中文表示
//=================================
function getchsname($enname,$common_chsfield) {
	while (list($key,$val)=each($common_chsfield)){
  	if ($key==$enname) 
    	return $val;
  }
  return $enname;   
}

//=================================
//采用外部定义好的输入式样
//=================================
function extinput($value,$type,$fact,$factarray,$rel_array) {
	if ($type==1) {
		if (is_array($factarray[0])) { //判断是否多维数组
			$multi_array=$factarray;
			for ($i=0;$i<sizeof($multi_array);$i++) {
				$factarray[$i]=$multi_array[$i][0];
			}
			$last="\n<script>\n <!-- \n common_array=new Array(".count($multi_array).");\n ";
			for ($i=0;$i<count($multi_array);$i++) {
				$last.="common_array[$i]=new Array(";
			for ($j=0;$j<count($multi_array[$i]);$j++) {
				$last.= '"'.$multi_array[$i][$j].'"';
				if ($j<(count($multi_array[$i])-1))
					$last.= ",";
				}
				$last.=");\n";
			}
			$last.="\n function common_dropmenu() { \n id=document.commonfrm.".$value.".selectedIndex; \n for (i=1;i<common_array[id].length;i++) { \n";
			$last.="tempoption=new Option(common_array[id][i],common_array[id][i]);document.commonfrm.".$rel_array[$value].".options[i-1]=tempoption;  	\n}}\n";
			$last.="//-->\n</script>\n";				
			$last.="<SELECT name=$value ONCHANGE=common_dropmenu()>";
		}else
			$last="<SELECT name=$value>";
		for ($i=0;$i<sizeof($factarray);$i++) {
			if ($fact!=$factarray[$i])
				$last.='<option value="'.$factarray[$i].'">'.$factarray[$i].'</option>';
			else $last.='<option selected>'.$fact."</option>";  
		}
		$last.="</SELECT>\n";
	}
	return $last;
}
  
//=================================
//显示菜单按钮
//=================================
function showmainbutton() {
	global $mainindex,$parent,$access,$common_dbname,$common_tbname,$common_condition,$temp_query,$common_perpage,$common_curpage,$common_type,$common_sort;
  if (($common_condition!='') && ($common_sort!=''))
  	$common_sqlstr="select count(*) from $common_tbname WHERE $common_condition ORDER BY $common_sort";
  elseif ($common_condition!='')
  	$common_sqlstr="select count(*) from $common_tbname WHERE $common_condition";
  elseif ($common_sort<>"")
  	$common_sqlstr="select count(*) from $common_tbname ORDER BY $common_sort";
  else 
  	$common_sqlstr="select count(*) from $common_tbname";
  $result=mysql_query($common_sqlstr);
 	$rows=mysql_result($result,0,0);
  echo "<table  width=100% border=0>";
  echo "<tr><td  valign='middle'>";
  echo "<INPUT TYPE='BUTTON' name='brow' value='浏 览' class=button onclick=window.location.href='$parent?common_mod=list&common_curpage=1&common_condition=".urlencode($common_condition).$temp_query."'>\n";
	$common_pages=ceil($rows/$common_perpage);
	if ($common_pages==0)
		$common_pages=1;
	//借$common_first为过滤变量，控制《增加》按钮的有效性		
  if ($access=='+')
  	$common_first="onclick=window.location.href='$parent?common_mod=add&common_condition=".urlencode($common_condition).$temp_query."'";
  else
    $common_first="";
  if ($common_type!='query')
  	echo "<INPUT TYPE='BUTTON' name='add' value='增 加' class=button $common_first>\n";
  echo "<INPUT TYPE='BUTTON' name='exit' value='退 出' class=button onclick=window.location.href='$mainindex'>\n";
  if ($common_pages>1)
		$common_first="<a href='$parent?common_mod=list&common_curpage=1&common_condition=".urlencode($common_condition).$temp_query."'  title='首页'><font face='Webdings'>9</font></a>";
	else
		$common_first="<font face='Webdings'>9</font>";
	if ($common_pages>1)
		$common_end="<a href='$parent?common_mod=list&common_curpage=$common_pages&common_condition=".urlencode($common_condition).$temp_query."' title='尾页'><font face='Webdings'>:</font></a>";
	else
		$common_end="<font face='Webdings'>:</font>";

	if ($common_curpage<=1) {
		$common_curpage=1;
		$common_nexpage=$common_curpage+1;
		if ($common_pages<=1)
			$common_next="<font face='Webdings'>8</font>";
		else
			$common_next="<a href='$parent?common_mod=list&common_curpage=$common_nexpage&common_condition=".urlencode($common_condition).$temp_query."' title='第 $common_nexpage 页'><font face='Webdings'>8</font></a>";
		$common_prev="<font face='Webdings'>7</font>";
		}else if (($common_curpage>1)&&($common_curpage<$common_pages)) {
		 	$common_nexpage=$common_curpage+1;
		 	$common_prepage=$common_curpage-1;
			$common_next="<a href='$parent?common_mod=list&common_curpage=$common_nexpage&common_condition=".urlencode($common_condition).$temp_query."' title='第 $common_nexpage 页'><font face='Webdings'>8</font></a>";
		 	$common_prev="<a href='$parent?common_mod=list&common_curpage=$common_prepage&common_condition=".urlencode($common_condition).$temp_query."' title='第 $common_prepage 页'><font face='Webdings'>7</font></a>";
		}else if ($common_curpage>=$common_pages) {
			$common_curpage=$common_pages;
		  $common_prepage=$common_curpage-1;
		 	$common_prev="<a href='$parent?common_mod=list&common_curpage=$common_prepage&common_condition=".urlencode($common_condition).$temp_query."' title='第 $common_prepage 页'><font face='Webdings'>7</font></a>";
		 	$common_next="<font face='Webdings'>8</font>";
		}
		 
    echo "</td><td valign='middle'>";
    echo "页次:<b>$common_curpage/$common_pages</b> 页  每页<b>$common_perpage</b>  记录数<b>$rows</b>  $common_first $common_prev $common_next $common_end \n ";
    echo "</td><form name='skip'  method='post' action='$parent?common_mod=list&common_condition=".urlencode($common_condition).$temp_query."'>";
    echo "<td valign='middle'>";    
    echo " 跳转到 第 <input type=text name='common_curpage' size='4'> 页";         
    echo " <input type='submit' name='ok' value='GO'>";
    echo "</td></FORM></tr></table>";
    echo "<HR color=red>";
}

//=================================
//*生成与字段类型相应的HTML INPUT语句，
//=================================
function getinput($value,$f_type,$fact,$max,$appendstyle) {
	if (preg_match("/_data_/i",$value))
  	return '';
  if (preg_match("/filename_/i",$value)) {
  	$last="<input type='file' name='$value'>";
  	return $last;
  }
  if ($max==0) {//不知长度另行处理
		preg_match("/(\()(\d+)/i",$f_type,$max);
  if (empty($max)) {
  	if ($f_type=='date') {
    	if (empty($fact))
      	$fact=date('Y-m-d');
      $max=10;
    }else if ($f_type=='datetime') {
			if (empty($fact))
      	$fact=date('Y-m-d H:i:s');
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
    switch ($f_type):
    case (!(strpos($f_type,'text')===False))||(!(strpos($f_type,'blob')===False)):
    	$last="<TEXTAREA  name=$value rows='4'' cols='60' $appendstyle nowrap>$fact</TEXTAREA>";
    	break;
    case (!(strpos($f_type,'int')===False)&&($max==1)):
      if ($fact==1)
    		$last="<INPUT TYPE='CheckBox' $appendstyle name=$value size=$size value=1 checked>";
    	else
    		$last="<INPUT TYPE='CheckBox' $appendstyle name=$value size=$size value=1>";
    	break;
    default:
    	$last="<INPUT TYPE='TEXT' name=$value size=$size value='$fact' maxlength=$max $appendstyle>";
		endswitch;
    return $last;
}

//======================主程序部分=====================
//=================================
// === 入口参数处理(先处理的部分)
//=================================
dbconnect($common_dbname);

$chscommon_tbname=getchsname($common_tbname,$common_chsfield);
$parent=$_SERVER['PHP_SELF'];
$common_sqlstr=$_POST["common_sqlstr"];
$common_rowid=$_GET["common_rowid"];
if (empty($common_perpage))
	$common_perpage=20;
$common_curpage=$_REQUEST['common_curpage'];
if (empty($common_curpage))
	$common_curpage=1;
$common_starpage=($common_curpage-1)*$common_perpage;

$common_query=$_SERVER['QUERY_STRING'];
$common_query=split("&",$common_query);
$temp_query="";
for ($i=0;$i<sizeof($common_query);$i++) {
	if (substr($common_query[$i],0,7)!='common_') {
		$temp_query=$temp_query.'&'.$common_query[$i];
	}
}

// 如果有过滤值传过来
if ($ext_filter==1) {
   if (isset($common_condition))
      $common_condition=stripslashes($common_condition);
   //如果有过滤的字段传入
   if (isset($common_fields))
     $common_fields=stripslashes($common_fields);
	else
     $common_fields='*';
}
if ($is_access)	  //是否采用限制
	if (!isset($access)) {  //限制方式
		$access='-';
	}else {}
else
	$access='+';

//== 安全性检查
if ((isset($common_sqlstr))&&($common_sqlstr!='')) {
	$common_sqlstr=stripslashes($common_sqlstr);
  $common_sqlstr=htmlspecialchars(urldecode($common_sqlstr));
//验证表名是否可能被替换
	preg_match("/(from)(\s+)(\w+)/i",$common_sqlstr,$k);
	if ($k[3]<>$common_tbname) {
		die("想干嘛！");
	}
}

$common_mod=$_GET['common_mod'];

if (empty($common_mod))
	$common_mod='list';	  	
// ===== 结束入口部分


//================================= 
//=== 显示附件
//=================================
	if ($common_mod=='showattach') {
		$common_sqlstr="select $fieldname,"."_data".strstr($fieldname,"_")." from $common_tbname limit $id,1";		
    	$result=mysql_query($common_sqlstr);
     	if (!($result)) {
     		echo "无效查询! ".$common_sqlstr;
     		exit;
     	}
     	if (mysql_num_rows($result)<=0)
     		exit;
     	$filename=mysql_result($result,0,0);
     	$data=mysql_result($result,0,1);
		header("Cache-control: max-age=31536000");
		header("Expires: " . gmdate("D, d M Y H:i:s",time()+31536000) . "GMT");
		header("Content-disposition: filename=$filename");
		header("Content-Length: ".strlen($data));
		if ($ext==".gif") {
  			header("Content-type: image/gif");
		}elseif ($ext==".jpg" or $ext==".jpeg") {
  			header("Content-type: image/pjpeg");
		}elseif ($ext==".png") {
  			header("Content-type: image/png");
		}else {
  			header("Content-type: unknown/unknown");
  			exit;
		}
			echo $data;
		exit;
	}

//=================================
// ---处理删除操作
//=================================
  if ($common_mod=='postdel') {
    showmainbutton();
	if ((isset($common_condition)) && (isset($common_sort)))
		$common_sqlstr="select * from $common_tbname where $common_condition ORDER BY $common_sort limit $common_rowid,1 ";
	else if (isset($common_condition))
		$common_sqlstr="select * from $common_tbname where $common_condition limit $common_rowid,1 ";
	else if (isset($common_sort))
		$common_sqlstr="select * from $common_tbname ORDER BY $common_sort limit $common_rowid,1 ";	
	else
	 	$common_sqlstr="select * from $common_tbname limit $common_rowid,1 ";
	 $result=executesql($common_sqlstr);
     if (mysql_num_rows($result)==0)
         exit;
     $cols=mysql_num_fields($result);
     $common_sqlstr="delete from $common_tbname WHERE ";
     for ($i=0;$i<$cols;$i++) {
         $fieldname=mysql_field_name($result,$i);
         $value=mysql_result($result,0,$i);
		 if (!(strpos($value,chr(92))===false)) {
			 $value=addslashes($value);
	     }
		 if (is_null($value))
			$common_sqlstr=$common_sqlstr."isnull($fieldname) AND ";
		 else
     	$common_sqlstr=$common_sqlstr."$fieldname='$value' AND ";    //生成条件语句
	 }
	 $common_sqlstr=substr($common_sqlstr,0,-5);
   executesql($common_sqlstr);
   echo '已执行删除!';
	 echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';
  }

//=================================
//---处理删除的界面
//=================================
  if ($common_mod=='del') {	
     $common_rowid=$common_rowid+$common_starpage;	
     echo "<center><p>\n";
     echo '请问是否要删除?</p><input type="button" value="   是   " onclick=window.location.href="'.$parent.'?common_mod=postdel&common_rowid='.$common_rowid.'&common_tbname='.$common_tbname.$temp_query.'">';
     echo '<input type="button" value="   否   " onclick="history.back(1)"></center>';
  }

//=================================	
// ---处理编辑的记录
//=================================
  if ($common_mod=='postedit') {
     showmainbutton();
 	 $wheresql=substr($common_sqlstr, strpos($common_sqlstr,'WHERE'),strlen($common_sqlstr)-strpos($common_sqlstr,'WHERE')+1);

     $result=executesql($common_sqlstr);
     if (mysql_num_rows($result)==0)
         exit;
     $cols=mysql_num_fields($result);
	  $wheresql=" WHERE ";
     for ($i=0;$i<$cols;$i++) {
         $fieldname=mysql_field_name($result,$i);
         $value=mysql_result($result,0,$i);
		 if (!(strpos($value,chr(92))===false)) {
			 $value=addslashes($value);
	   }
		 if (is_null($value))
             $wheresql=$wheresql."isnull($fieldname) AND ";    
	     else
             $wheresql=$wheresql."$fieldname='$value' AND ";    //生成条件语句
	 }
     $wheresql=substr($wheresql,0,-5);

	 $common_sqlstr="UPDATE $common_tbname SET";
   for ($i=0;$i<$cols;$i++) {
      $value=mysql_field_name($result,$i);        
      if (!preg_match('/_data_/i',$value)) {        	
        	if (preg_match('/filename_/i',$value)) {
         		if ($_FILES[$value]['error']>0) {
         			$common_sqlstr.=' '.$value.'=" ",';
         			$value=mysql_field_name($result,$i+1);
         			$common_sqlstr.=' '.$value.'=" ",';
         		}else {
         				$attachment=$_FILES[$value]['tmp_name'];
            		$filesize=filesize($attachment);
            		$filenum=fopen($attachment,"rb");
            		$filestuff=fread($filenum,$filesize);
            		fclose($filenum);
            		$name=$_FILES[$value]["name"];
            		$common_sqlstr.=" $value='".addslashes($name)."',";
            		$value=mysql_field_name($result,$i+1);
            		$common_sqlstr.=" $value='".addslashes($filestuff)."',";
        		}        		
        	}else{
				if (!(strpos($_POST[$value],chr(92))===false)) {
					$_POST[$value]=addslashes($_POST[$value]); 					
				}		
				$common_sqlstr=$common_sqlstr." $value='".$_POST[$value]."',";        		
        }
      }
     }
     $common_sqlstr=substr($common_sqlstr,0,-1).' '.$wheresql;
     if (executesql($common_sqlstr)>0) {
         echo "修改成功 ";
	       echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';		 
			}
  }

//=================================
// --编辑记录界面模式
//=================================
  if ($common_mod=='edit') {
     echo "<P><B>编辑记录</B></P>";
     showmainbutton();
    
     $common_rowid=$common_rowid+$common_starpage;  
   
     echo "\n<FORM name=commonfrm method='post' enctype='multipart/form-data' action='$parent?common_mod=postedit$temp_query' onSubmit='submitonce(this)'>\n";
     echo "<TABLE WIDTH='100%' BORDER='1' BGCOLOR=#C0C0FF>";
     if (($ext_filter==1) && (ltrim(rtrim($common_condition))<>'') && (ltrim(rtrim($common_sort))<>'')) 
			$common_sqlstr="select $common_fields from $common_tbname WHERE $common_condition ORDER BY $common_sort limit $common_rowid,1"; 
     else if (($ext_filter==1) && (ltrim(rtrim($common_condition))<>'')) 
        $common_sqlstr="select $common_fields from $common_tbname WHERE $common_condition limit $common_rowid,1";
     else if (($ext_filter==1) && (ltrim(rtrim($common_sort))<>'')) 
        $common_sqlstr="select $common_fields from $common_tbname ORDER BY $common_sort limit $common_rowid,1";    
     else 
         $common_sqlstr="select * from $common_tbname limit $common_rowid,1";
	 $result=executesql($common_sqlstr);

     if (mysql_num_rows($result)==0)
         exit;
     $cols=mysql_num_fields($result);
     for ($i=0;$i<$cols;$i++) {
     	$value=mysql_field_name($result,$i);
      $type=mysql_field_type($result,$i);
      $len=mysql_field_len($result,$i);
      $chsvalue=getchsname($value,$common_chsfield);
      $fact=mysql_result($result,0,$i);
			$factarray="common_ar_$value";
			$factarray=$$factarray;
			$appendstyle="common_ap_$value";
			$appendstyle=$$appendstyle;
			if (is_array($factarray)) {  //采用单选输入框
				$rel_array="common_rel_$value";
				$rel_array=$$rel_array;
				if (!is_array($rel_array)) { //如果是第二下拉菜单,重定义数组
					$factarray=array(0=>"$fact");
				}
				$inputfield=extinput($value,1,$fact,$factarray,$rel_array);
			}else{
      	$inputfield=getinput($value,$type,$fact,$len,$appendstyle);
			}
      if ($inputfield<>'') {
      	echo "<TR>";
        echo "<TD>$chsvalue</TD>\n";
        echo "<TD>$inputfield</TD></TR>\n";
      }
     }
     $cols--;
     echo "<INPUT TYPE='HIDDEN'  name='common_sqlstr' value='".urlencode($common_sqlstr)."'>";
     echo "<TR><TD colspan=$cols><INPUT TYPE='SUBMIT' name='add' value='确认'><TD></TR></TABLE></FORM>\n";
     exit;
  }

//=================================
// ---处理增加的记录
//=================================
  if ($common_mod=='postadd') {
     showmainbutton();

     $result=executesql("show fields from $common_tbname");
     $rows=mysql_num_rows($result);
     $sqlquery="INSERT INTO $common_tbname VALUES(";
		 for ($i=0;$i<$rows;$i++) {
    	 $value=mysql_result($result,$i,'field');
        if (!preg_match('/_data_/i',$value)) {
        	if (preg_match('/filename_/i',$value)) {
         		if (($$value=="none")||($$value=="")) {
         			$sqlquery.='"","",';
         		}else {
         			$attachment=$$value;
            		$filesize=filesize($attachment);
            		$filenum=fopen($attachment,"rb");
            		$filestuff=fread($filenum,$filesize);
            		fclose($filenum);
            		$name=$value."_name";
            		$sqlquery.="'".addslashes($$name)."','".addslashes($filestuff)."',";
        		}        		
        	}else {
         		$sqlquery=$sqlquery.'"'.$_POST[$value].'",';
        	}
        }
     }
     $sqlquery=substr($sqlquery,0,-1).')';
     if (executesql($sqlquery)>0) {
        echo "添加成功";
	 			echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';
			}
  }

//=================================
// ---增加记录界面模式
//=================================
  if ($common_mod=='add') {
     echo "<B>添加记录</B><BR>";
     showmainbutton();
     echo "\n<FORM method='post' name='commonfrm' enctype='multipart/form-data' action='$parent?common_mod=postadd$temp_query'  onSubmit='submitonce(this)'>\n";
     echo "<TABLE WIDTH='100%'' BORDER='1'' BGCOLOR=#C0C0FF>";
     $result=executesql("show fields from $common_tbname");
     $cols=mysql_num_rows($result);
     for ($i=0;$i<$cols;$i++) {
         $value=mysql_result($result,$i,'field');
         $type=mysql_result($result,$i,'type');
         $chsvalue=getchsname($value,$common_chsfield);
         $inputfield='';

					$factarray="common_ar_$value";
					$factarray=$$factarray;
					if (is_array($factarray)) {  //采用单选输入框
						$rel_array="common_rel_$value";
						$rel_array=$$rel_array;
						$inputfield=extinput($value,1,$fact,$factarray,$rel_array);
					}else{
      			$inputfield=getinput($value,$type,$fact,$len,$appendstyle);
					}
         	if ($inputfield<>'') {
         		echo "<TR>";
         		echo "<TD>$chsvalue</TD>\n";
         		echo "<TD>$inputfield</TD></TR>\n";
         	}
     }

     $cols--;
     echo "<TR><TD colspan=$cols><INPUT TYPE='SUBMIT' name='add' value='确认'><TD></TR></TABLE></FORM>\n";
     exit;
  }

//=================================
// ---列表显示界面模式(默认模式)
//=================================
  if ($common_mod=='list') {
     echo "<B>显示记录</B><BR>";
     showmainbutton();

     if (($ext_filter==1) && (ltrim(rtrim($common_condition))<>'') && (ltrim(rtrim($common_sort))<>'')){
        $common_sqlstr="select $common_fields from $common_tbname WHERE $common_condition ORDER BY $common_sort limit $common_starpage,$common_perpage";
     }
     else if (($ext_filter==1) && (ltrim(rtrim($common_condition))<>'')){
        $common_sqlstr="select $common_fields from $common_tbname WHERE $common_condition limit $common_starpage,$common_perpage";
     }
     else if (($ext_filter==1) && (ltrim(rtrim($common_sort))<>'')){
        $common_sqlstr="select $common_fields from $common_tbname ORDER BY $common_sort limit $common_starpage,$common_perpage";
     }
     else{
         $common_sqlstr="select * from  $common_tbname limit $common_starpage,$common_perpage";
     }
     $result=executesql($common_sqlstr);
     $num=mysql_num_fields($result);
  
     echo "<TABLE width=100% BORDER='1' class=table2>";
     echo "<TR  BGCOLOR=#808000>";
     echo "<TD>&nbsp;</TD>";
     //字段显示并翻译为中文
     for ($i=0;$i<$num;$i++) {
         $value=mysql_field_name($result,$i);
         if (!preg_match("/_data_/i",$value)) {
         	$value=getchsname($value,$common_chsfield);
         	echo "<TD align='center'><B>$value</B></TD>";
         }
     }
     echo "</TR>";
     //显示记录内容
     $rows=mysql_num_rows($result);
     for ($i=0;$i<$rows;$i++) {
         echo "<TR  BGCOLOR=#C0C0FF>";
         $wheresql=" WHERE ";
         $htmlstring='';
         for ($j=0;$j<$num;$j++) {
            $fieldname=mysql_field_name($result,$j);
            //不处理_data
         	if (!preg_match("/_data_/i",$fieldname)) {
             	$value=mysql_result($result,$i,$j);
             	//根据附件名处理
             	if ((eregi("filename_",$fieldname))&&(!empty($value))) {
             		$ext=strtolower(strstr($value,"."));
             		if (preg_match("/\.gif|\.png|\.jpg|\.jpeg/i",$value)) 
             			$value="<a href='$parent?mod=showattach&common_tbname=$common_tbname&fieldname=$fieldname&id=$i&ext=$ext' target=_blank title='$value'><img width='50' height='50' src='$parent?mod=showattach&common_tbname=$common_tbname&fieldname=$fieldname&id=$i&ext=$ext'></a>";
             		else
             			$value="<a href='$parent?mod=showattach&common_tbname=$common_tbname&fieldname=$fieldname&id=$i&ext=$ext'>$value</a>";             			
             	}
						if (($value==null)||($value==' ')) $value='&nbsp';
             	$htmlstring.="<TD>$value</TD>";
             }
         }
         echo "<TD width='60'>";         
         if ($access=='+') {
              $rowid=$i;
            if ($common_type!='query'){  
            		echo "<a href='$parent?common_mod=del&common_rowid=$rowid&common_curpage=$common_curpage$temp_query'>删除</a> ";
		      		
			      		//$common_condition=urlencode($common_condition);
 			      		
			      		echo "<a href='$parent?common_mod=edit&common_rowid=$rowid&common_curpage=$common_curpage$temp_query'>修改</a>\n";
			      }
            if (isset($externallist))
              	echo "<a href=$externallist?common_rowid=".$rowid."&common_tbname=".$common_tbname."&common_curpage=$common_curpage$temp_query target=_blank>显示</a>\n";
         }else
              echo "&nbsp;";
         echo "</TD>$htmlstring</TR>\n";
     }
     echo "</TABLE>\n";
     
  }
?>
</BODY>
</HTML>