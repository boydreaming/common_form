<?
/**
 * �ļ�����������ͨ������ɾ���Ľ���ģ��
 ���÷��� ��
 require ("../common_v2.php");
//===========
 �ⲿ����ı���˵����1.(version 2 �ı���뺬��һ��primary_key���ֶ�)
                     2.�������common_ Ϊǰ׺�ı���
//===========
 $common_mod: ��ʽ(list,add,edit,ext_list)
 $common_dbname   ���ݿ���
 $common_tbname ����
 $mainindex ���ص������� (���ղ���ʾ���˳�����ť)
 $common_sql ����SQL��ѯ��䣬��ʹ�ÿ�ʡcommon_tbname

//===========
 �ⲿ����ɶ���ı�����
//===========
 $common_search_field:�������Ĺؼ��ֶ�
 $common_type: �ñ��������Ƿ�������ӡ�ɾ�����޸Ĺ��ܣ�Ĭ��Ϊ��|add|del|edit|list|query|filter|search|��,����Ϊ��|list|��ʱ��ֻ�������
 $common_chsfield : �ֶ���Ӣ����
                   ��:$common_chsfield=Array("case_info_id_a"=>"�������", "customername"=>"����")
 $ext_filter:(0|1)�Ƿ�����ⲿ����,��$common_condition,$common_fields���
 $common_condition: �������� sql ��� where����ַ���,���б�Ҫ�ɼ�urlencode,����searchģʽ�󣬸�ֵ�ᱻ����
 $common_fields:  ָ��Ҫ��ʾ��Щ�ֶΣ���","�ָ�,�����ֶα�����
 $common_sort: �����ֶ�����
 $common_ar_<�ֶ���> : �ⲿ����ʽ��,����������. ���������絥ѡ������ʽ��
 $common_rel_<�ֶ���>:  ���$common_ar_<�ֶ���>�Ƕ�ά���飬�����ɹ������飬���磺$common_rel_papertype1=array("papertype1"=>"papertype2");����ʾpapertype1,papertype2�γɹ�������papertype1����papertype2.֧����������������磺$common_rel_truename=array("truename"=>array("operator","department"));
 $common_perpage:  ÿҳ���ټ�¼��
 $common_ap_<�ֶ���>: ��INPUT��׷����ʽ��" disabled"; ��ʹ��Ӧ�����Ϊ��,"readonly" ��ʹ��Ӧ�����Ϊֻ����"hidden" ,��ʹ���������,ͬʱ"hidden"Ҳ��ʹ�����б��в���ʾҲ�ɽ�˵���javascript����onfocus,onclick��
 $common_ap_commonfrm: ����commonfrm ���ύ����Ŀ��ƣ��ɿ���onsubmit�Ƚű�   Ĭ��ΪonSubmit='submitonce(this)'
 $common_default_<�ֶ���> Ĭ��ֵ
 $common_str_edit:���޸ġ���ť�Զ���
 $common_str_add:�����ӡ���ť�Զ���
 $common_buttons: ׷����ʾ�İ�ť
 $common_extprg: ��<����><�޸�>��ʾ�������ⲿ����,�ⲿ����ֻ�������ӿڣ�����ģʽ$common_mod,��ǰ����ֵ$common_id,��������ֶ��л����"��ʾģʽ"
 $common_extprg_<�ֶ���>: �ɶ�����Ӧ�ֶ������õ����ó���,����ģʽ��$common_extprg,���ֶβ����ڱ༭����ʾ����
 $common_extprg_<�ֶ���>_button: ���Զ�����Ӧ�ֶ���ʾ��ť��ʽ��Ĭ��Ϊ�����ˡ�
                       ���button����ȫ�Զ�����<button onclick=open(#common_id)>֮�࣬����ʹ�ø��Զ�����ʽ��
                       ע1�����Ҫ����$common_id,�����#common_id.
                       ע2��$common_extprg_<�ֶ���>Ҳ�������
 $common_link_<�ֶ���>:����ĳһ�ֶ���ʾʱ�ɳ�������һҳ��,���Զ�׷�Ӹ��ֶε�ֵ��url�С�
 $common_submit_out ���ύ��Ĵ�����������ɾ���ġ��� 	$common_submit_out="./test.php";����������print_r($_POST);
 $common_button: �ñ��������Ƿ��ȸ���һ����ѯ������ⲿ����ñ���ֵΪ1��˵�����в�ѯ���ܣ����ⲿ�����ѯ����$common_condition����һ���Ǳ������룬
 				����common_mod=listģ�飬�Ժ��޸ġ����ӡ�ɾ��ʱ��url��������(��Ϊ�ص�ʱ$common_condition�ٴεõ���ҳ��ͬ��������ֵ�������ֵ��һ����)��
 				����common=list_conditionģ��
 $common_ext_deal: �ⲿ����ñ�����˵����Ҫ�ⲿ����,��Ȼʹ�ñ�ҳ��<����><�޸�>,�������ص�ʱ����$mod==ext_deal,
 $common_titlecolor: �б���ⱳ��ɫ
 $common_linecolor: ��ϸ�б���ɫ
 $common_alterlinecolor: ������ϸ�б���ɫ
 $common_condition_linecolor: array() ����ĳ���ֶ������趨���б���ɫ �������飬֧�ֶ���������common_condition_linecolor_col or���ʹ��
 $common_condition_linecolor_color: ����ĳ���ֶ������趨���б���ɫ array()
 $common_js_date: �Ƿ�����Ĭ�ϵ�������ʱ��ؼ���Ĭ�ϵ���true�����ݿ��ֶ�Ϊdate�������ڣ�Ϊdatetime��������ʱ�䣬���ÿؼ�·����./_common��
 $common_meg:�Զ�����ʾ��Ϣ λ���ڡ�--��ʾ��¼--����
 $common_footer:ҳ��ײ���ʾ����
 $common_attach_<�ֶ���>: 0ΪĬ�ϣ�1Ϊ���ֶα��渽����������16λ�ֳ���Ψһ����;�ù�����Ҫ���� attachment.php;�ù���                          ��Ҫ$common_fields ���ж��壬ɾ����¼�󣬻����attachment.phpɾ����Ӧ���ݡ�
 $common_after_del:ɾ����¼���׷�Ӳ���,���Դ��͵Ĳ���Ϊ#common_delid
 $common_lock_style:Ĭ��Ϊ overflow:auto;width:100%;height:450px; ��Ӱ�����峤��
 $common_title:ҳ�����
 $common_after_del:ɾ������תִ��
//===========
 css��javascript��˵��
//===========
	$listtable ��������ʽ
  CSS�����¼����Զ���Ӱ��.table2 .button
  javascript  ����ͨ��$common_ap_<�ֶ���> ������js
  ./_common/common.js�б�������õ�javascript


����ע��:
  1����������ظ����ⲿ�����ڵ��ñ�����ʱ��Ӧ������common��ͷ�ı������Լ���Ӧ�ñ���FIELDͬ���ı�����
  2���ⲿ����ģʽcommon_mod��Ϊlist,add,edit,��Ҫע�����,������Ҫ����Щ�������ж�,��Ϊ����ص��������,Ȼ��,�ٽ��뱾����
  3����common.php��Ҫ��ͬ���ڣ�������primary_key,����֧��common�ĸ����ϴ�ģʽ
*/
/*
 * ============================================================================
 * ��Ȩ���� (C) �Ϻ��е������޹�˾������----�ͻ���Ӧ��������
 * ��˾��ַ������·535��
 * ----------------------------------------------------------------------------
 * ��ע�������˺ʹ������ڣ������޸ģ���ע���޸��ˣ��޸����ں��޸����ݣ�
 * ============================================================================
 * <--������Ϣ-->
 * �����ˣ�
 * �������ڣ�
 * ----------------------------------------------------------------------------
 * <--�޸���Ϣ-->
 * �޸��ˣ�boydreaming
 * �޸����ڣ�2008/1/16
 * �޸����ݣ�fix $common_condition urlencode bug

 * �޸��ˣ�boydreaming
 * �޸����ڣ�2008/1/7
 * �޸����ݣ�fix $common_fields bug

 * �޸��ˣ�jinh
 * �޸����ڣ�2008/1/3
 * �޸����ݣ������Զ�����ʾ��Ϣ δ֪�ڡ�--��ʾ��¼--���� $common_meg

 * �޸��ˣ�boydreaming
 * �޸����ڣ�2007/12
 * �޸����ݣ��޸� $common_extprg_<�ֶ���>,ʹ��������ֶ���ֵ�Ļ���������ʾ"����"����ֵ���.

 * �޸��ˣ�jinh
 * �޸����ڣ�2008/1/3
 * �޸����ݣ������Զ�����ʾ��Ϣ δ֪�ڡ�--��ʾ��¼--����$common_meg

 * ============================================================================
*/


//���Ʋ��ݳ�����Ϣ
error_reporting  (E_ERROR |E_PARSE);
if ((!isset($common_dbname))||(!isset($common_tbname))) {
	if (!isset($common_sql))
		die( "common_dbname|common_tbname|common_sql δ����");
}

//======================�ڲ���ⶨ��=====================
//===================================================
class Common{
	public $dbname,$sql,$cols,$rows,$common_chsfield,$tbname,$mod,$perpage,$type,$curpage,$oldurl,$buttons,$str_add;
	public $fieldsinfo=array(),$extprg="",$mainindex="",$message="",$condition="",$search_field="",$searchkey="",$listcondition;

//�������ݿ�
	function dbconnect($dbname) {
		$link=@mysql_pconnect('localhost','remote','admin') or die("�޷���ʾ���ݣ����ӷ�����ʧ�ܣ��������Ա��ϵ!".mysql_error());
		if (empty($dbname))
			$dbname="westmis";
		mysql_select_db($dbname) or die("���ݿ�:$dbname û�ҵ����������Ա��ϵ!".mysql_errno());
    mysql_query("SET NAMES 'GBK'");
	}

//ִ��SQL���
	public function executesql($sqlquerystring) {
		$result=@mysql_query($sqlquerystring) or die("��Ч���! <BR> $sqlquerystring <BR>".mysql_error());
		return $result;
	}

//***ת��Ӣ���ֶ�Ϊ���ı�ʾ
	function getchsname($enname) {
		$enname=str_replace("`","",$enname);
		foreach($this->common_chsfield as $key=>$val) {
  		if ($key==$enname)
    		return $val;
		}
  	return $enname;
	}

	//�ж��Ƿ������ַ�
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
//��ʾ�˵���ť
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
  		echo "<BUTTON class=button onclick=window.location.href='$parent?common_mod=list&common_curpage=1&common_condition=".$this->listcondition.$this->oldurl."'>� ��</BUTTON>\n";
		}
		$common_pages=ceil($this->rows/$this->perpage);
		if (empty($common_pages))
			$common_pages=1;
	//��$common_firstΪ���˱��������ơ����ӡ���ť����Ч��
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
  		echo "<BUTTON class=button onclick=window.location.href='$parent?common_mod=filter&common_condition=$tmp".$this->oldurl."'>ɸ ѡ</BUTTON>\n";
  	if (strpos($this->type,"search|")>0){
  		$temp="";
  		if (!empty($this->search_field)){
  			$temparray=explode(",",$this->search_field);
  			for ($i=0;$i<count($temparray);$i++)
  				$temp.=$common->getchsname($temparray[$i]).",";
  			$temp=substr($temp,0,-1);
  		}
  		echo "<INPUT type='text' name=common_searchkey value=\"".$this->searchkey."\" title=$temp><INPUT TYPE=SUBMIT value='�� ��' class=button >\n";
  	}
  	if ($this->mainindex!="")
  		echo "<INPUT TYPE='BUTTON' name='exit' value='�� ��' class=button onclick=window.location.href='$mainindex'>\n";

  	if(!empty($this->message)){ // add by jinh 080103
  		echo "<font color=red>(".$this->message.")</font>";
  	}
		
  	$temp="list";

		if (($this->mod=="list")||($this->mod=="filter")||($this->mod=="search"))
			$temp=$this->mod;
  	if (($common_pages>1)&&($this->curpage<>1))
			$common_first="<a href='$parent?common_mod=$temp&common_curpage=1&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."'  title='��ҳ'><font face='Webdings'>9</font></a>";
		else
			$common_first="<font face='Webdings'>9</font>";
		if (($common_pages>1)&&($this->curpage<>$common_pages))
			$common_end="<a href='$parent?common_mod=$temp&common_curpage=$common_pages&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='βҳ'><font face='Webdings'>:</font></a>";
		else
			$common_end="<font face='Webdings'>:</font>";

		if ($this->curpage<=1) {
			$this->curpage=1;
			$common_nexpage=$this->curpage+1;
 			if ($common_pages<=1)
				$common_next="<font face='Webdings'>8</font>";
			else
				$common_next="<a href='$parent?common_mod=$temp&common_curpage=$common_nexpage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='�� $common_nexpage ҳ'><font face='Webdings'>8</font></a>";
			$common_prev="<font face='Webdings'>7</font>";
		}else if (($this->curpage>1)&&($this->curpage< $common_pages)) {
		 	$common_nexpage=$this->curpage+1;
		 	$common_prepage=$this->curpage-1;
			$common_next="<a href='$parent?common_mod=$temp&common_curpage=$common_nexpage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='�� $common_nexpage ҳ'><font face='Webdings'>8</font></a>";
		 	$common_prev="<a href='$parent?common_mod=$temp&common_curpage=$common_prepage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='�� $common_prepage ҳ'><font face='Webdings'>7</font></a>";
		}else if ($this->curpage>=$common_pages) {
			$this->curpage=$common_pages;
		  $common_prepage=$this->curpage-1;
		 	$common_prev="<a href='$parent?common_mod=$temp&common_curpage=$common_prepage&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."' title='�� $common_prepage ҳ'><font face='Webdings'>7</font></a>";
		 	$common_next="<font face='Webdings'>8</font>";
		}
  
    echo "</td></form><td valign='middle'>";
    echo "ҳ��:<b>$this->curpage/$common_pages</b> ҳ  ÿҳ<b>".$this->perpage."</b>  ��¼��<b>$this->rows</b>  $common_first $common_prev $common_next $common_end \n ";
    echo "</td><form name='skip'  method='post' action='$parent?common_mod=$temp&common_condition=$tmp&common_searchkey=".$this->searchkey.$this->oldurl."'>";
    echo "<td valign='middle'>";
    echo " ��ת�� �� <input type=text name='common_curpage' size=4> ҳ";
    echo " <input type='submit' name='ok' value='GO'>";
    echo "</td></FORM></tr></table>";
    echo "<HR color=red>";
	}
}


//======================��������=====================
//=================================
//������չ����õ�����ʽ������Ҫ����������
//=================================
function extinput($value,$type,$fact,$factarray,$rel_array,$appendstyle,$size) {
  if ($size>=40)
     $size=40;
	$common_array="common_ar_$value";
	if (is_array($factarray[0])) { //�ж��Ƿ��ά����
		//���ɶ�������
		$last="\n<script> var $common_array=new Array(".count($factarray).");\n ";
		for ($i=0;$i<count($factarray);$i++) {
			$last.=$common_array."[$i]=new Array(";
			for ($j=0;$j<count($factarray[$i]);$j++) {
				//������ά����Ļ�������������ַ���
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
		//���ɶ�������
		$last="\n<script> var $common_array=new Array(".count($factarray).");\n ";
		$i=0;
		while (list($arrkey,$arrval)=each($factarray)) {
			$last.=$common_array."[$i]=new Array(";
			$last.= '"'.$arrval.'"';
			$last.=");\n";
			$i++;
		}
	}
	if (is_array($rel_array[$value])) { //��ά����
		$tmp=implode(",",$rel_array[$value]);
		$last.=" var ".$value."_list=new poplistselect('".$value."','$tmp'); $value"."_list.init(1,$common_array);\n</script>\n";
		$last.="<INPUT name=$value VALUE='$fact' type=text  size=$size $appendstyle><button type=button class=cmbbutton onClick='getpopval($value,$value"."_list".")'></button>";
	}else{ //��ά���鼰һά
		$last.=" var ".$value."_list=new poplistselect('".$value."',''); \n $value"."_list.init(0,$common_array);\n</script>\n";
		$last.="<INPUT name=$value VALUE='$fact' type=text  size=$size $appendstyle><button type=button class=cmbbutton onClick='getpopval($value,$value"."_list".")'></button>";
	}
	return $last;
}



//=================================
//*�������ֶ�������Ӧ��HTML INPUT���
//=================================
function getinput($value,$f_type,$fact,$max,$appendstyle,$appendjsdate) {
	global $common_js_date;
  if ($max==0) {//��֪�������д���
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


//======================�����򲿷�=====================
//=================================
// === ��ڲ�������(�ȴ���Ĳ���)
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

//�ж��Ƿ�Ԥ������SQL����
if (isset($common_sql)){
  //ȥ������Ŀո�
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
		echo "��sql�����WHERE�������϶��壡";
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

//ԭ��URL����Ĳ�������
$common_query=$_SERVER['QUERY_STRING'];
$common_query=split("&",$common_query);

$temp_query="";
for ($i=0;$i<sizeof($common_query);$i++) {
	if ((substr($common_query[$i],0,7)!='common_')&&(!empty($common_query[$i]))) {
		$temp_query=$temp_query.'&'.$common_query[$i];
	}
}

//ȥ��δβ&����
if (substr($temp_query,-1)=="&")
	$temp_query=substr($temp_query,0,-1);

$common->oldurl=$temp_query;

//Ĭ������ӣ�ɾ�����޸Ĺ���
if (empty($common_type)) 
	$common_type="|add|del|edit|list|filter|search|";
$common->type=$common_type;
if (empty($common_str_edit)) 
	$common_str_edit="�޸�";
if (empty($common_str_add))
	$common_str_add="�� ��";
$common->str_add=$common_str_add;

//���SQL��֧��ɾ�������
if (!strpos($common->dbname,",")===false){
	$common_type=str_replace("add|","",$common_type);
	$common_type=str_replace("del|","",$common_type);
}

//javascript  Ԥ���ò���
if (empty($common_ap_commonfrm))
	$common_ap_commonfrm=" onSubmit='submitonce(this)'";

if (!isset($common_js_date)){
	echo "<SCRIPT language=JavaScript src='/westmis/_common/WdatePicker.js'></SCRIPT>\n";
	echo "<SCRIPT language=JavaScript src='/westmis/_common/submitonce.js'></SCRIPT>\n";	
	$common_js_date=true;
}

//====

// ����й���ֵ������
// �����Ԥ������������Ϊ�ǡ��������ť������

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

//�����ؼ���
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

//==ʶ��primary_key
if (strpos($common->dbname,",")===false)
	$result=$common->executesql("select $common_fields from $common_tbname where 1=2") or die ("��ѯʧ��:".mysql_error());
else
	$result=$common->executesql($common_sql." and 1=2") or die ("��ѯʧ��:".mysql_error());
$common->cols=mysql_num_fields($result);
$common_index="";
$common_array=0;
$common_attachment=0;
$tmp="";
for ($i=0;$i< $common->cols;$i++) {
	$common->fieldsinfo[$i]=mysql_fetch_field($result,$i);
	$value=$common->fieldsinfo[$i]->name;
	if ($value=='key') {//�����ּ�``
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
  //Ԥ����������鲿��
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
	die("û���ҵ�primary_key�ֶ�.��������Զ���Ķ������SQL��䣬Ӧ��һ��primary_key��FIELDS��!");

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
//��ɫ����
if (empty($common_titlecolor))
	$common_titlecolor="#b5c7e7";

if (empty($common_alterlinecolor))
	$common_alterlinecolor="#D8D8D8";
// ===== ������ڲ���


//=================================
// ---����ɾ������
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
				//����и���Ҫ��������
				if ($common_attachment) {
					$result=$common->executesql("select * from $common_tbname where $common_index=".$common_delid[$i]);
					$cols=mysql_num_fields($result);
					$c=0;
					echo "ɾ����ظ��� ";
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
// ---����༭�ļ�¼
//=================================
  if ($common_mod=='postedit') {
  	$common_sqlstr=urldecode($common_sqlstr);

 	if (strpos($common_sqlstr,'WHERE')===false)
    		exit("SQL ���ȱ��WHERE,����ִ�У�");
 	$wheresql=substr($common_sqlstr, strpos($common_sqlstr,'WHERE'),strlen($common_sqlstr)-strpos($common_sqlstr,'WHERE')+1);
	if (strpos($common->dbname,",")===false)
		$common_sqlstr="UPDATE $common_tbname SET";
	else
	 	$common_sqlstr="UPDATE ".$common->dbname." SET";
  for ($i=0;$i< $common->cols;$i++) {
    $fieldname=$common->fieldsinfo[$i]->name;
    $value=str_replace("`","",$fieldname);
		if (!(strpos($_POST[$value],chr(92))===false)) {  //���������"\"
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
    	echo "�޸ĳɹ� ";
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
// --�༭��¼����ģʽ
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

			if (is_array($factarray)) {  //���õ�ѡ�����
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
     echo "<TR><TD colspan=2><INPUT TYPE='SUBMIT' name='add' value='ȷ��'><TD></TR></TABLE></FORM>\n";
  }

//=================================
// ---�������ӵļ�¼
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
        	echo "��ӳɹ�";
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
// ---���Ӽ�¼����ģʽ
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
  		$tmp="common_extprg_".$value; //�������ֶδ�����չ�����ⲿ����������
  		if (isset($$tmp))
  			$appendstyle="hidden";
  		if (is_array($factarray)) {  //���õ�ѡ�����
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
    echo "<TR><TD><INPUT TYPE='SUBMIT' name='add' value='ȷ��'></TD>";
    echo "<TD><button class=button onclick='javascript:history.go(-1)'>����</button></TD></TR></TABLE></FORM>\n";
  }

//=================================
// ---�б���ʾ����ģʽ(Ĭ��ģʽ)
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

    //����sql���
    if (strpos($common->dbname,",")===false){
    	if ((isset($common_sqlstr))&&($common_sqlstr!='')) {
    		//���˷����ַ�
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
    	echo "<TD style=$common_fixtitlecol><input type=button style='width:52px' onclick=\"{ if (confirm('ȷ��ɾ����¼��?')) {this.document.common_frm.submit();return true;}return false;}\" value=\"ɾ��\"></TD>";
    else
    	echo "<TD>&nbsp;</TD>";
     //�ֶ���ʾ������Ϊ����
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
    //��ʾ��¼����
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
        //��������ֵ,������˵��ֶ���û������ֵ���ܻᵼ���Ҳ�������ֵ
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
        //������appendstyle=hidden
        if ($appendstyle<>"hidden") {
					if (($value==null)||(trim($value)==""))
						$value="&nbsp;";
					else
						$value=stripslashes($value);
					//�ⲿ���ô���
      		if (!(empty($common_extprg))){
      			if (strpos($common_extprg,"?")===false)
      				$value="<a href='$common_extprg?common_mod=list&common_id=$common_id' title='(��ʾģʽ)' > $value </a>";
      			else
      				$value="<a href='$common_extprg&common_mod=list&common_id=$common_id' title='(��ʾģʽ)' > $value </a>";
      		}
      		$tmp="common_extprg_".$fieldname; //�Ƿ�����Զ����ֶι���
      		$tmp1="common_extprg_".$fieldname."_button"; //�Ƿ�����Զ����ֶ���ʾ��ť
      		if (isset($$tmp1))
      			$tmp1=$$tmp1;
      		elseif ((empty($value))||($value=="&nbsp;"))
      			$tmp1="����";
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

          //��������
          $tmp="common_attach_$fieldname";
          if (($$tmp)&&($value<>"&nbsp;")) {
          	$value="<iframe allowTransparency=true height=30 width=308 SCROLLING=AUTO FRAMEBORDER=0 src=\"$parentdir/attachment.php?attachid=$value&action=list\"></iframe>";
          }

          $htmlstring.="<TD>$value</TD>";
        }
      }
      echo "<TD style=$common_fixdatacol>";
      if ($num>0) { //�м�¼�����common_id�쳣
      	if ((!isset($common_id))||($common_id==""))
      		die("�Ҳ�������ֵ��");
      }
      if (strpos($common_type,"del|")>0)
        	echo "<input type=CheckBox name=common_delid[] value=$common_id>";
      if (strpos($common_type,"edit|")>0) {
  			if (empty($common_extprg)){ //��������ⲿ��������ⲿ����
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
// ---ɸѡ����ģʽ(Ĭ��ģʽ)
//=================================
  if ($common_mod=='filter') {
    $common->showmainbutton();
    if (!$common->rows) {
    	exit("�����ݣ�����Ҫɸѡ��");
    }

    echo "\n<TABLE width=100% BORDER='1' width=100%><form name='common_frm' method=post action='$parent?common_mod=postfilter&common_id=$common_id&common_curpage=$common_curpage$temp_query&common_condition=".urlencode($common_condition)."'>";
    if (strpos($common_condition,"ORDER")>0) {
    	$common_temp=substr($common_condition,0,strpos($common_condition,"ORDER")-1);
    }
    echo "<TR><TH>����</TH><TH>����</TH><TH align=right><input name=submit type=submit value='ִ��ɸѡ'></TH></TR>";
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
    echo "<TR><TH colspan=3 align=right>(�������ΪAND��ϵ)<input name=submit type=submit value='ִ��ɸѡ'></TH></TR></form>";
    echo "</TABLE>";
	}


if (!empty($common_footer))
	echo $common_footer;
?>
