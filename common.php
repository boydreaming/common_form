<?
/*
 ʹ��˵�� 
 2005��5��  last modify boydreaming
 ���÷��� ��
 require ("../common.php");
 
//===========
 �ⲿ������붨��ı�����
//===========
 $common_mod: ��ʽ(list,add,edit)
 $common_dbname   ���ݿ���
 $common_tbname ����
 $mainindex ���ص�������
 
//===========
 �ⲿ����ɶ���ı�����
//===========
 $common_type: �ñ��������Ƿ�������ӡ�ɾ�������޸Ĺ��ܣ��ⲿ����ñ���ֵΪqueryʱ��ֻ�����������������ӡ�ɾ�������޸�
 $common_chsfield : �ֶ���Ӣ����
                   ��:$common_chsfield=Array("case_info_id_a"=>"�������", "customername"=>"����")
 $ext_filter:�Ƿ�����ⲿ����,��$common_condition���
 $common_condition: �������� sql ��� where����ַ���
 $common_sort: �����ֶ�����
 $common_ar_<�ֶ���>  �ⲿ����ʽ��,����������. ���������絥ѡ������ʽ��
 $common_rel_<�ֶ���>  ���$common_ar_<�ֶ���>�Ƕ�ά���飬�����ɹ������飬���磺$common_rel_papertype1=array("papertype1"=>"papertype2");����ʾ
 papertype1,papertype2�γɹ�������papertype1����papertype2.
 $common_perpage  ÿҳ���ټ�¼��
 $common_ap_<�ֶ���> ׷����ʽ����" disabled"; ��ʹ��Ӧ�����Ϊ��
 
//===========
 �ⲿcss��javascript�ɶ���
//===========
  CSS�����ⲿ�������¼�����.table2 .button
  javascript ������function submitonce(theform)

����ע��:
  1����������ظ����ⲿ�����ڵ��ñ�����ʱ��Ӧ������common��ͷ�ı������Լ���Ӧ�ñ���FIELDͬ���ı�����
  2���������ģ�鴫��access,common_dbname����������ᱻ��Ϊ�������
  5���ⲿ����ģʽcommon_mod��Ϊlist,add,edit,��Ҫע�����,������Ҫ����Щ�������ж�,��Ϊ����ص��������,Ȼ��,�ٽ��뱾����

*/
//���Ʋ��ݳ�����Ϣ
error_reporting  (E_ERROR |E_PARSE);
if ((!empty($_REQUEST['access']))||(!empty($_REQUEST['common_dbname']))) {
	die( "����");
}
if ((!isset($common_dbname))||(!isset($common_tbname))) {
	die( "ȱ�ٲ���!");
}

/*
//�������ݿ�
  function dbconnect($common_dbname="westmis"){
    if (!mysql_connect('localhost','admin','admin')) {
       echo mysql_errno().":".mysql_error()."<BR>";
       die("�޷���ʾ���ݣ����ӷ�����ʧ�ܣ��������Ա��ϵ!");
    }else{
    	if (!mysql_select_db($common_dbname)) {
      	echo mysql_errno().":".mysql_error()."<BR>";
        die("$common_dbname û�ҵ����������Ա��ϵ!");
      }
    }
  }

//ִ��SQL���
	function executesql($sqlquerystring) {
		$result=mysql_query($sqlquerystring);
		if (!$result) {
			echo mysql_errno() . ": " . mysql_error(). "<BR>"; 
			die("��Ч���! $sqlquerystring <BR>");
		}
		return $result;
	}
*/


//======================��������=====================
//=================================
//***ת��Ӣ���ֶ�Ϊ���ı�ʾ
//=================================
function getchsname($enname,$common_chsfield) {
	while (list($key,$val)=each($common_chsfield)){
  	if ($key==$enname) 
    	return $val;
  }
  return $enname;   
}

//=================================
//�����ⲿ����õ�����ʽ��
//=================================
function extinput($value,$type,$fact,$factarray,$rel_array) {
	if ($type==1) {
		if (is_array($factarray[0])) { //�ж��Ƿ��ά����
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
//��ʾ�˵���ť
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
  echo "<INPUT TYPE='BUTTON' name='brow' value='� ��' class=button onclick=window.location.href='$parent?common_mod=list&common_curpage=1&common_condition=".urlencode($common_condition).$temp_query."'>\n";
	$common_pages=ceil($rows/$common_perpage);
	if ($common_pages==0)
		$common_pages=1;
	//��$common_firstΪ���˱��������ơ����ӡ���ť����Ч��		
  if ($access=='+')
  	$common_first="onclick=window.location.href='$parent?common_mod=add&common_condition=".urlencode($common_condition).$temp_query."'";
  else
    $common_first="";
  if ($common_type!='query')
  	echo "<INPUT TYPE='BUTTON' name='add' value='�� ��' class=button $common_first>\n";
  echo "<INPUT TYPE='BUTTON' name='exit' value='�� ��' class=button onclick=window.location.href='$mainindex'>\n";
  if ($common_pages>1)
		$common_first="<a href='$parent?common_mod=list&common_curpage=1&common_condition=".urlencode($common_condition).$temp_query."'  title='��ҳ'><font face='Webdings'>9</font></a>";
	else
		$common_first="<font face='Webdings'>9</font>";
	if ($common_pages>1)
		$common_end="<a href='$parent?common_mod=list&common_curpage=$common_pages&common_condition=".urlencode($common_condition).$temp_query."' title='βҳ'><font face='Webdings'>:</font></a>";
	else
		$common_end="<font face='Webdings'>:</font>";

	if ($common_curpage<=1) {
		$common_curpage=1;
		$common_nexpage=$common_curpage+1;
		if ($common_pages<=1)
			$common_next="<font face='Webdings'>8</font>";
		else
			$common_next="<a href='$parent?common_mod=list&common_curpage=$common_nexpage&common_condition=".urlencode($common_condition).$temp_query."' title='�� $common_nexpage ҳ'><font face='Webdings'>8</font></a>";
		$common_prev="<font face='Webdings'>7</font>";
		}else if (($common_curpage>1)&&($common_curpage<$common_pages)) {
		 	$common_nexpage=$common_curpage+1;
		 	$common_prepage=$common_curpage-1;
			$common_next="<a href='$parent?common_mod=list&common_curpage=$common_nexpage&common_condition=".urlencode($common_condition).$temp_query."' title='�� $common_nexpage ҳ'><font face='Webdings'>8</font></a>";
		 	$common_prev="<a href='$parent?common_mod=list&common_curpage=$common_prepage&common_condition=".urlencode($common_condition).$temp_query."' title='�� $common_prepage ҳ'><font face='Webdings'>7</font></a>";
		}else if ($common_curpage>=$common_pages) {
			$common_curpage=$common_pages;
		  $common_prepage=$common_curpage-1;
		 	$common_prev="<a href='$parent?common_mod=list&common_curpage=$common_prepage&common_condition=".urlencode($common_condition).$temp_query."' title='�� $common_prepage ҳ'><font face='Webdings'>7</font></a>";
		 	$common_next="<font face='Webdings'>8</font>";
		}
		 
    echo "</td><td valign='middle'>";
    echo "ҳ��:<b>$common_curpage/$common_pages</b> ҳ  ÿҳ<b>$common_perpage</b>  ��¼��<b>$rows</b>  $common_first $common_prev $common_next $common_end \n ";
    echo "</td><form name='skip'  method='post' action='$parent?common_mod=list&common_condition=".urlencode($common_condition).$temp_query."'>";
    echo "<td valign='middle'>";    
    echo " ��ת�� �� <input type=text name='common_curpage' size='4'> ҳ";         
    echo " <input type='submit' name='ok' value='GO'>";
    echo "</td></FORM></tr></table>";
    echo "<HR color=red>";
}

//=================================
//*�������ֶ�������Ӧ��HTML INPUT��䣬
//=================================
function getinput($value,$f_type,$fact,$max,$appendstyle) {
	if (preg_match("/_data_/i",$value))
  	return '';
  if (preg_match("/filename_/i",$value)) {
  	$last="<input type='file' name='$value'>";
  	return $last;
  }
  if ($max==0) {//��֪�������д���
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

//======================�����򲿷�=====================
//=================================
// === ��ڲ�������(�ȴ���Ĳ���)
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

// ����й���ֵ������
if ($ext_filter==1) {
   if (isset($common_condition))
      $common_condition=stripslashes($common_condition);
   //����й��˵��ֶδ���
   if (isset($common_fields))
     $common_fields=stripslashes($common_fields);
	else
     $common_fields='*';
}
if ($is_access)	  //�Ƿ��������
	if (!isset($access)) {  //���Ʒ�ʽ
		$access='-';
	}else {}
else
	$access='+';

//== ��ȫ�Լ��
if ((isset($common_sqlstr))&&($common_sqlstr!='')) {
	$common_sqlstr=stripslashes($common_sqlstr);
  $common_sqlstr=htmlspecialchars(urldecode($common_sqlstr));
//��֤�����Ƿ���ܱ��滻
	preg_match("/(from)(\s+)(\w+)/i",$common_sqlstr,$k);
	if ($k[3]<>$common_tbname) {
		die("����");
	}
}

$common_mod=$_GET['common_mod'];

if (empty($common_mod))
	$common_mod='list';	  	
// ===== ������ڲ���


//================================= 
//=== ��ʾ����
//=================================
	if ($common_mod=='showattach') {
		$common_sqlstr="select $fieldname,"."_data".strstr($fieldname,"_")." from $common_tbname limit $id,1";		
    	$result=mysql_query($common_sqlstr);
     	if (!($result)) {
     		echo "��Ч��ѯ! ".$common_sqlstr;
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
// ---����ɾ������
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
     	$common_sqlstr=$common_sqlstr."$fieldname='$value' AND ";    //�����������
	 }
	 $common_sqlstr=substr($common_sqlstr,0,-5);
   executesql($common_sqlstr);
   echo '��ִ��ɾ��!';
	 echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';
  }

//=================================
//---����ɾ���Ľ���
//=================================
  if ($common_mod=='del') {	
     $common_rowid=$common_rowid+$common_starpage;	
     echo "<center><p>\n";
     echo '�����Ƿ�Ҫɾ��?</p><input type="button" value="   ��   " onclick=window.location.href="'.$parent.'?common_mod=postdel&common_rowid='.$common_rowid.'&common_tbname='.$common_tbname.$temp_query.'">';
     echo '<input type="button" value="   ��   " onclick="history.back(1)"></center>';
  }

//=================================	
// ---����༭�ļ�¼
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
             $wheresql=$wheresql."$fieldname='$value' AND ";    //�����������
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
         echo "�޸ĳɹ� ";
	       echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';		 
			}
  }

//=================================
// --�༭��¼����ģʽ
//=================================
  if ($common_mod=='edit') {
     echo "<P><B>�༭��¼</B></P>";
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
			if (is_array($factarray)) {  //���õ�ѡ�����
				$rel_array="common_rel_$value";
				$rel_array=$$rel_array;
				if (!is_array($rel_array)) { //����ǵڶ������˵�,�ض�������
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
     echo "<TR><TD colspan=$cols><INPUT TYPE='SUBMIT' name='add' value='ȷ��'><TD></TR></TABLE></FORM>\n";
     exit;
  }

//=================================
// ---�������ӵļ�¼
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
        echo "��ӳɹ�";
	 			echo '<script>window.location="'.$parent.'?common_mod=list&common_condition='.urlencode($common_condition).$temp_query.'";</script>';
			}
  }

//=================================
// ---���Ӽ�¼����ģʽ
//=================================
  if ($common_mod=='add') {
     echo "<B>��Ӽ�¼</B><BR>";
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
					if (is_array($factarray)) {  //���õ�ѡ�����
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
     echo "<TR><TD colspan=$cols><INPUT TYPE='SUBMIT' name='add' value='ȷ��'><TD></TR></TABLE></FORM>\n";
     exit;
  }

//=================================
// ---�б���ʾ����ģʽ(Ĭ��ģʽ)
//=================================
  if ($common_mod=='list') {
     echo "<B>��ʾ��¼</B><BR>";
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
     //�ֶ���ʾ������Ϊ����
     for ($i=0;$i<$num;$i++) {
         $value=mysql_field_name($result,$i);
         if (!preg_match("/_data_/i",$value)) {
         	$value=getchsname($value,$common_chsfield);
         	echo "<TD align='center'><B>$value</B></TD>";
         }
     }
     echo "</TR>";
     //��ʾ��¼����
     $rows=mysql_num_rows($result);
     for ($i=0;$i<$rows;$i++) {
         echo "<TR  BGCOLOR=#C0C0FF>";
         $wheresql=" WHERE ";
         $htmlstring='';
         for ($j=0;$j<$num;$j++) {
            $fieldname=mysql_field_name($result,$j);
            //������_data
         	if (!preg_match("/_data_/i",$fieldname)) {
             	$value=mysql_result($result,$i,$j);
             	//���ݸ���������
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
            		echo "<a href='$parent?common_mod=del&common_rowid=$rowid&common_curpage=$common_curpage$temp_query'>ɾ��</a> ";
		      		
			      		//$common_condition=urlencode($common_condition);
 			      		
			      		echo "<a href='$parent?common_mod=edit&common_rowid=$rowid&common_curpage=$common_curpage$temp_query'>�޸�</a>\n";
			      }
            if (isset($externallist))
              	echo "<a href=$externallist?common_rowid=".$rowid."&common_tbname=".$common_tbname."&common_curpage=$common_curpage$temp_query target=_blank>��ʾ</a>\n";
         }else
              echo "&nbsp;";
         echo "</TD>$htmlstring</TR>\n";
     }
     echo "</TABLE>\n";
     
  }
?>
</BODY>
</HTML>