<?php

//
//     To display the calendars, type 
//     include_once("BaseCalendar.inc");
//     $newCal = new BaseCalendar();
//
//modify 02/28/2005 adding the possibility to navigate in the calendar.

class BaseCalendar {

var $numYear = ""; 
var $textMonth = ""; 
var $thisMonthTimestamp = "";
var $numMonth = "";
var $nextMonthTimestamp = "";
var $numNextMonth = "";
var $textNextMonth = "";
var $yearNextMonth = "";
var $followingMonthTimestamp = "";
var $numFollowingMonth = "";
var $calWidth = "130px";
var $calBGColor = "#f7e4bf";
var $calTextColor = "#000000";


// constructor function, sets current date as default
function BaseCalendar($YYYY=false, $Mmm=false, $calWid=false, $calBGC=false, $calTC=false) {
  $this->numYear = ($YYYY) ? $YYYY : date("Y");
  $this->textMonth = ($Mmm) ? $Mmm : date("M");
  $this->thisMonthTimestamp = strtotime("1 $this->textMonth $this->numYear");
  $this->numMonth = date("n",$this->thisMonthTimestamp);
  $this->nextMonthTimestamp = strtotime("+1 month",$this->thisMonthTimestamp);
  $this->numNextMonth = date("n",$this->nextMonthTimestamp);
  $this->textNextMonth = date("M",$this->nextMonthTimestamp);
  $this->yearNextMonth = date("Y",$this->nextMonthTimestamp);
  $this->followingMonthTimestamp = strtotime("+2 month",$this->thisMonthTimestamp);
  $this->numFollowingMonth = date("n",$this->followingMonthTimestamp);
  $this->calWidth = ($calWid) ? $calWid : $this->calWidth;
  $this->calBGColor = ($calBGC) ? $calBGC : $this->calBGColor;
  $this->calTextColor = ($calTC) ? $calTC : $this->calTextColor;
	$this->nextmonth_nav=date("M",strtotime("+2 month",$this->thisMonthTimestamp));
	$this->prevmonth_nav=date("M",strtotime("-1 month",$this->thisMonthTimestamp));
	$this->nextmonth_year_nav=date("Y",strtotime("+2 month",$this->thisMonthTimestamp));
	$this->prevmonth_year_nav=date("Y",strtotime("-1 month",$this->thisMonthTimestamp));
	$this->actual_year=date("Y");
	$this->actual_date=date("M");
}

function display_cal(){
  echo"<table padding=0 cellpadding=0 style=\"text-align:left; border:1px solid black; float:left; background-color:".$this->calBGColor."; color:".$this->calTextColor."\">\n";
  echo"<tr valign=\"top\"><td align=\"center\" colspan=\"2\" style=\"font-size:13px; line-height:1em; border-bottom:1px solid black\">
	<a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$this->actual_date."&amp;y=".$this->actual_year." \">Текущая дата</a></td>";
	echo"<tr valign=\"top\">
	<td style=\"font-size:13px; line-height:1em; border-bottom:1px solid black\"><a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$this->prevmonth_nav."&amp;y=".$this->prevmonth_year_nav."\"><<</a></td>
	<td align=\"right\" style=\"font-size:13px; line-height:1em; border-bottom:1px solid black\"><a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$this->nextmonth_nav."&amp;y=".$this->nextmonth_year_nav." \">>></a></td></tr>"; 
	echo"<tr valign=\"top\"><td>";
  $this->displayMonth();
  echo"</td><td style=\"border-left:1px solid black\">";
  $this->displayNextMonth();
  echo"</td></tr></table>\n";
}

function displayMonth() {
	$db=new db;
  $daysInMonth = date("t",$this->thisMonthTimestamp);
  $dayMonthStarts = date("N",$this->thisMonthTimestamp);
  $dayNextMonthStarts = date("N",$this->nextMonthTimestamp);
  //$today = date("n/j");
	$req_event="SELECT * FROM calendar WHERE month='".$this->textMonth."'";
	$query=$db->bb_query($req_event);
	//print_r($event);
  echo "<table style=\"padding:0; color:#6D4F16; font-size:13px; line-height:1em; width:".$this->calWidth."\">\n";
  /*$temp_month_name = $this->textMonth;*/
  $month_n_=array("Jan" => "Янв","Feb" => "Фев","Mar" => "Мар","Apr" => "Апр","May" => "Май","Jun" => "Июн","Jul" => "Июл","Aug" => "Авг","Sep" => "Сен","Oct" => "Окт","Nov" => "Ноя","Dec" => "Дек");
  echo "<tr><th colspan=\"7\" style=\"text-align:center\">".$month_n_[$this->textMonth]."&nbsp;&nbsp;".$this->numYear."</th></tr>\n";
  echo "<tr><th>Пн</th><th>Вт</th><th>Ср</th> <th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th></tr>\n";
  echo "<tr style=\"text-align:center\">\n";
  for ($i=1; $i<$dayMonthStarts; $i++) {echo "<td>&nbsp;</td>\n";}
  for ($i=1; $i<=$daysInMonth; $i++) {
		//print_r ($rec);
		$req_ev="SELECT day, month, year, recurrence FROM calendar WHERE day='".$i."' and month='".$this->textMonth."' and year='".$this->numYear."'";
		$query=$db->bb_query($req_ev);
		$my_row=$db->fetch_row($query);
		$req_rec="SELECT day, month, year, recurrence FROM calendar WHERE day='".$i."' and year='".$this->numYear."' and recurrence='1'";
		$qu_re=$db->bb_query($req_rec);
		$rec=$db->fetch_row($qu_re);
		$today=$my_row['1']."/".$my_row['0'];
		$datacheck=date("M/j",strtotime("$i $this->textMonth $this->numYear"));
		if ($today==$datacheck or $rec['3']=='1') {
      echo "<td style=\"background-color:#f7c86d; text-align:center; color:black\">
			<a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$this->textMonth."&amp;y=".$this->numYear."&amp;day=".$i."\">$i</a></td>";
    } else echo "<td style=\"text-align:center\">".$i."</td>\n";
			if (date("N",strtotime("$i $this->textMonth $this->numYear"))==7 && $i<$daysInMonth) {
      echo "</tr><tr style=\"text-align:center\">\n";
    } else if (date("N",strtotime("$i $this->textMonth $this->numYear"))==7 && $i==$daysInMonth) {
      echo "</tr>\n";
    } else if ($i==$daysInMonth) {
      for ($h=$dayNextMonthStarts; $h<7; $h++) { 
        echo "<td>&nbsp;</td>\n";
      }
    echo "</tr>\n";
    }
  }
  echo "</table>\n";
}

function displayNextMonth() {
	$db=new db;
  $daysInNextMonth = date("t",$this->nextMonthTimestamp);
  $dayNextMonthStarts = date("N",$this->nextMonthTimestamp);
  $dayFollowingMonthStarts = date("N",$this->followingMonthTimestamp);
  echo "<table style=\"padding:0; color:#6D4F16; font-size:13px; line-height:1em; width:".$this->calWidth."\">\n";
  $month_n_=array("Jan" => "Янв","Feb" => "Фев","Mar" => "Мар","Apr" => "Апр","May" => "Май","Jun" => "Июн","Jul" => "Июл","Aug" => "Авг","Sep" => "Сен","Oct" => "Окт","Nov" => "Ноя","Dec" => "Дек");
  echo "<tr><th colspan=\"7\" style=\"text-align:center\">".$month_n_[$this->textNextMonth]."&nbsp;&nbsp;".$this->yearNextMonth."</th></tr>\n";
  echo "<tr><th>Пн</th><th>Вт</th><th>Ср</th> <th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th></tr>\n";
  echo "<tr style=\"text-align:center\">\n";
  for ($i=1; $i<$dayNextMonthStarts; $i++) {echo "<td>&nbsp;</td>\n";}
  for ($i=1; $i<=$daysInNextMonth; $i++) {
			$req_ev="SELECT day, month, year, recurrence FROM calendar WHERE day='".$i."' and month='".$this->textNextMonth."' and year='".$this->yearNextMonth."'";
			$query=$db->bb_query($req_ev);
			$my_row=$db->fetch_row($query);
			$req_rec="SELECT day, month, year, recurrence FROM calendar WHERE day='".$i."' and year='".$this->yearNextMonth."' and recurrence='1'";
			$qu_re=$db->bb_query($req_rec);
			$rec=$db->fetch_row($qu_re);
			$today=$my_row['1']."/".$my_row['0'];
			$datacheck=date("M/j",strtotime("$i $this->textNextMonth $this->yearNextMonth"));
		if ($today==$datacheck or $rec['3']=='1') {
    echo "<td style=\"background-color:#f7c86d; text-align:center; color:black\">
			<a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$this->textNextMonth."&amp;y=".$this->yearNextMonth."&amp;day=".$i."\">$i</a></td>";
    } else echo "<td style=\"text-align:center\">$i</td>\n";
      if (date("N",strtotime("$i $this->textNextMonth $this->yearNextMonth"))==7 && $i<$daysInNextMonth) {
      echo "</tr><tr style=\"text-align:center\">\n";
    } else if (date("N",strtotime("$i $this->textNextMonth $this->yearNextMonth"))==7 && $i==$daysInNextMonth) {
      echo "</tr>\n";
    } else if ($i==$daysInNextMonth) {
      for ($h=$dayFollowingMonthStarts; $h<7; $h++) {
      echo "<td>&nbsp;</td>\n";
      }
    echo "</tr>\n";
    }
  }
  echo "</table>\n";
}

function displayday($day){
	$db = new db;
	if(!isset($_REQUEST['month'])){$month=date("M");}else{$month=$_REQUEST['month'];}
	if(!isset($_REQUEST['y'])){$y=date("Y");}else{$y=$_REQUEST['y'];}
	echo "<table style=\"padding:0; border:dotted 1px #dedede; color:#6D4F16; font-weight:bold; font-size:13px; line-height:1em; width:320px;\">";
        $month_n_=array("Jan" => "Янв","Feb" => "Фев","Mar" => "Мар","Apr" => "Апр","May" => "Май","Jun" => "Июн","Jul" => "Июл","Aug" => "Авг","Sep" => "Сен","Oct" => "Окт","Nov" => "Ноя","Dec" => "Дек");
	echo "<tr valign=\"top\"><td colspan=\"2\">".$day."&nbsp;-&nbsp;".$month_n_[$month]."&nbsp;-&nbsp;".$y."</td></tr>";
	$r=0;
	for($i='09';$i<21;$i++){
		$req_day="SELECT * FROM calendar WHERE (ora_app like '".$i."%' and day='".$day."' and month='".$month."' and year='".$y."') or (recurrence ='1' and day='".$day."' and ora_app like '".$i."%')";
		$q_day=$db->bb_query($req_day);
		//print_r ($app_day);
		if($r==0){$row="style=\"background:#ffc180;\"";}else{$row="";}
		echo "<tr ".$row."><td width=\"20\">".$i."</td><td>";
		while($app_day=$db->fetch_array($q_day)){
		//print_r ($app_day);
		echo "<p class=\"line\"><a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$month."&amp;y=".$y."&amp;day=".$day."&amp;id=".$app_day['0']."\">".$app_day['1']." - ".$app_day['5']."</a><p>";}
		echo "</td></tr>";
		$r++;
		if($r>1)$r=0;
		}
	
	echo "</table>";
}
function week($target_week_day){ 
		$db= new db;     
		if(!isset($_REQUEST['month'])){$month=date("M");}else{$month=$_REQUEST['month'];}
		if(!isset($_REQUEST['y'])){$y=date("Y");}else{$y=$_REQUEST['y'];}
	   //I find in wich day of the week we are
				 $today=date("w",strtotime("$target_week_day ".$month." ".$y.""));
				 //echo "TODAY".$today."<br>";
			if ($today==0){$how="+".($today+1)." days";}elseif($today==1){$how='';}else{$how="-".($today-1)." days";}
			echo "<table style=\"padding:0; color:#6D4F16; font-size:13px; line-height:1em; width:300px;\">\n";
                        $month_n_=array("Jan" => "Янв","Feb" => "Фев","Mar" => "Мар","Apr" => "Апр","May" => "Май","Jun" => "Июн","Jul" => "Июл","Aug" => "Авг","Sep" => "Сен","Oct" => "Окт","Nov" => "Ноя","Dec" => "Дек");
                        $day_n_=array("Mon" => "Пн","Tue" => "Вт","Wed" => "Ср","Thu" => "Чт","Fri" => "Пт","Sat" => "Сб","Sun" => "Вс");
			echo "<tr valign=\"top\"><td colspan=\"2\">".$target_week_day."&nbsp;-&nbsp;".$month_n_[$month]."&nbsp;-&nbsp;".$y."</td></tr>";
			$r=0;
			for($i=0; $i<7; $i++){
			if($r>1)$r=0;
			if($r==0){$row="style=\"background:#ffc180;\"";}else{$row="";}
			echo "<tr ".$row.">";
			  echo "<td style=\"text-align:left; color:black font-weight:bold; font-size:13px; width:70px;\">";
					 	/*echo date("D/d/M",strtotime("$target_week_day ".$month." ".$y." ".$how.""));*/
                                                echo $day_n_[date("D",strtotime("$target_week_day ".$month." ".$y." ".$how.""))];
                                                echo"/";
                                                echo date("d",strtotime("$target_week_day ".$month." ".$y." ".$how.""));
                                                echo"/";
                                                echo $month_n_[date("M",strtotime("$target_week_day ".$month." ".$y." ".$how.""))];
                                                echo"<br>";
						$days=date("j",strtotime("$target_week_day ".$month." ".$y." ".$how.""));
						$months=date("M",strtotime("$target_week_day ".$month." ".$y." ".$how.""));
						$years=date("Y",strtotime("$target_week_day ".$month." ".$y." ".$how.""));
						$target_week_day++;
				$req_day="SELECT * FROM calendar WHERE (day='".$days."' and month='".$months."' and year='".$years."') or (recurrence ='1' and day='".$days."') ORDER BY ora_app";
				//echo $req_day;
				$q_day=$db->bb_query($req_day);
								echo "</td>";
				echo "<td>";
				while($app_day=$db->fetch_array($q_day)){
				echo "<p class=\"line\"><a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$months."&amp;y=".$years."&amp;day=".$days."&amp;id=".$app_day['0']."\">".$app_day['1']." - ".$app_day['5']."</a><p>";}
				echo"</td>";
				echo"</tr>\n";
		 	
	
			$r++;
			}
			
		 echo "</table>\n";
}
function displayweek_event() {
  $daysInMonth = date("t",$this->thisMonthTimestamp);
  $dayMonthStarts = date("w",$this->thisMonthTimestamp);
  $dayNextMonthStarts = date("w",$this->nextMonthTimestamp);
  $today = date("n/j");
   for ($i=0; $i<$dayMonthStarts; $i++) {echo "<td>&nbsp;</td>\n";}
  for ($i=1; $i<=$daysInMonth; $i++) {
    if ($today==date("n/j",strtotime("$i $this->textMonth $this->numYear"))) {
      echo "<td style=\"background-color:#f7c86d; text-align:center; color:black\">
			<a href=\"".$_SERVER['PHP_SELF']."?act=agenda&amp;month=".$this->textMonth."&amp;y=".$this->numYear."&amp;day=".$i."\">$i</a></td>";
    } else echo "<td style=\"text-align:center\">$i</td>\n";
    if (date("w",strtotime("$i $this->textMonth $this->numYear"))==6 && $i<$daysInMonth) {
      echo "</tr><tr style=\"text-align:center\">\n";
    } else if (date("w",strtotime("$i $this->textMonth $this->numYear"))==6 && $i==$daysInMonth) {
      echo "</tr>\n";
    }
  }
  echo "</table>\n";
}
function event_form($day='',$month='',$year='',$id=''){
	$db=new db;
	if($id!=''){
		$r_mod_ev="SELECT * FROM calendar WHERE id='".$id."'";
		$q_m=$db->bb_query($r_mod_ev);
		$ev=$db->fetch_array($q_m);
		$month=$ev['month'];
		$day=$ev['day'];
		$year=$ev['year'];
		$app=$ev['appointment'];
                $owners_car=$ev['owners_car'];
                $owners_name=$ev['owners_name'];
                $contact_phone=$ev['contact_phone'];
		$rec=$ev['recurrence'];
		$hours=$ev['ora_app'];
		$hour=substr($hours,0,2);
		$min=substr($hours,3,4);
		$sub="Отредактировать";
		$id="<input type=\"hidden\" name=\"id\" value=\"".$id."\" />";
	}else{
		$app='';
                $owners_car='';
                $owners_name='';
                $contact_phone='';
		$rec='0';
		$ore='09';
		$min='00';
		$sub="Записаться";
		$id='';
	}
echo "<br /><table style=\"float:right; padding:0; color:#6D4F16; font-size:13px; line-height:1em; width:100%;\">";
echo "<form action=\"".$_SERVER['PHP_SELF']."\" name=\"add_app\" method=\"POST\">";
echo "<input type=\"hidden\" name=\"act\" value=\"agenda\" />";
echo $id;
echo "<input type=\"hidden\" name=\"month\" value=\"".$month."\" />";
echo "<input type=\"hidden\" name=\"y\" value=\"".$year."\" />";
echo "<input type=\"hidden\" name=\"day\" value=\"".$day."\" />";
echo "<input type=\"hidden\" name=\"sub_app\" value=\"sub_app\" />";
echo "<tr><td>Выберите вид работ (что конкретно требуется делать):<br />";
/*echo "<input type=\"text\" name=\"appoint\" value=\"".$app."\" size=\"40\"/>";*/
echo "<select name=\"appoint\" value=\"".$app."\" size=\"1\"/>";
if(''!=$app) {
echo "<option selected=\"selected\">";
echo $app;
echo "</option>";
} else {}
include "select_menu_table.php";
echo "</select>";
echo "</td></tr>";
echo "<tr><td>Ваш авто:<br />";
echo "<select name=\"owners_car\" value=\"".$owners_car."\" size=\"1\"/>";
if(''!=$owners_car) {
echo "<option selected=\"selected\">";
echo $owners_car;
echo "</option>";
} else {}
include "select_car_make_table.php";
echo "</select>";
echo "</td></tr>";
echo "<tr><td>Ваше имя:<br /><input type=\"text\" name=\"owners_name\" size=\"15\" value=\"".$owners_name."\" /></td></tr>";
if(1==$_SESSION['pass']) {
echo "<tr><td>Контакт. т.<br /><input type=\"text\" name=\"contact_phone\" size=\"15\" value=\"".$contact_phone."\" />&nbsp;&nbsp;(эту информацю увидит только специалист)</td></tr>";
} else {
echo "<tr><td>Контакт. т.<br /><input type=\"text\" name=\"contact_phone\" size=\"15\" value=\"\" />&nbsp;&nbsp;(эту информацю увидит только специалист)</td></tr>";
}
echo "<tr><td><input type=\"hidden\" type=\"checkbox\" name=\"recur\" value=\"0\"";
if($rec==1){echo " checked=\"checked\"";}
echo "	title=\"поставьте галочку, чтобы добавить повторно\" /></td></tr>";	
echo "<tr><td>Дата<br />";
echo"<select name=\"day_app\">
<option value=\"0\" selected>--день--</option>";
for($i=1;$i<=31;$i++){
	if($day==$i){
 	echo "<option selected value=\"$i\">$i</option>\n";
	}else{echo "<option value=\"$i\">$i</option>\n";}
	//echo "<option value=\"$i\">$i</option>\n";
}
echo "</select>";
echo "<select name=\"month_app\"><option value=\"0\" selected >--месяц---</option>";
$month_n_=array("Jan" => "Янв","Feb" => "Фев","Mar" => "Мар","Apr" => "Апр","May" => "Май","Jun" => "Июн","Jul" => "Июл","Aug" => "Авг","Sep" => "Сен","Oct" => "Окт","Nov" => "Ноя","Dec" => "Дек");
$month_n=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
foreach($month_n as $key=>$value){
	if($month==$value){
 	echo "<option selected value=\"$value\">$month_n_[$value]</option>\n";
	}else{echo "<option value=\"$value\">$month_n_[$value]</option>\n";}
	//echo "<option value=\"".$value."\">".$value."</option>\n";
}
echo "</select>";
echo"<select name=\"year_app\"><option value=\"0\" selected >--год--</option>";
for($i=2005;$i<=2020;$i++){
 	if($year==$i){
 	echo "<option selected value=\"$i\">$i</option>\n";
	}else{echo "<option value=\"$i\">$i</option>\n";}
	//echo "<option value=\"$i\">$i</option>\n";
}
echo "</select>";
echo "</td></tr>";
echo "<tr><td>Часы - ";
echo"<select name=\"hour\">";
for($i=11;$i<=19;$i++){
	if(strlen($i)==1){$i="0".$i;}
	if($hour==$i){
 	echo "<option selected value=\"".$i."\">".$i."</option>\n";
	}else{echo "<option value=\"";
	printf('%02d',$i);
	echo"\">";
	printf('%02d',$i);
	echo"</option>\n";}
	}
	echo "</select>";
	echo"Минуты - <select name=\"minuts\">";
	for($i=0;$i<=50;){
	if(strlen($i)==1){$i="0".$i;}
	if(strlen($i)==1){$i="0".$i;}
 	if($min==$i){
 	echo "<option selected value=\"$i\">$i</option>\n";
	}else{echo "<option value=\"$i\">$i</option>\n";}
        $i=$i+10;
	}
echo "</select>";
//;<input type=\"text\" name=\"hour\" value=\"".$ore."\" size=\"2\"/><b>:</b><input type=\"text\" name=\"minuts\" value=\"".$min."\" size=\"2\"/><font color=\"red\">wite in the format 00:00</font></td></tr>";
echo "<tr><td>
		<input  type=\"checkbox\" name=\"delapp\" value=\"1\"	title=\"Для отмены поставьте сразу две галочки\" />
		<input  type=\"checkbox\" name=\"delapp2\" value=\"1\"	title=\"Для отмены поставьте сразу две галочки\" />
		<font color=\"red\">для отмены поставьте сразу две галочки</font><br /><br />
		<input type=\"submit\" value=\"".$sub."\" name=\"sub_app\" />
		</td></tr>";
echo "</table>";
	
}
function add_event(){
	$db= new db;
	$ora=$_REQUEST['hour'].":".$_REQUEST['minuts'];
	if($_REQUEST['day_app']=='0'){$daye=date('d');}else{$daye=$_REQUEST['day_app'];}
	if($_REQUEST['month_app']=='0'){$monthe=date("M");}else{$monthe=$_REQUEST['month_app'];}
	if($_REQUEST['year_app']=='0'){$yeare=date('Y');}else{$yeare=$_REQUEST['year_app'];}
	if(isset($_REQUEST['recur'])){$recur=$_REQUEST['recur'];}else{$recur=0;}
	$new_event = "INSERT INTO calendar (ora_app,day,month,year,appointment,owners_name,contact_phone,owners_car,recurrence)
	VALUES ('".$ora."', '".$daye."', '".$monthe."', '".$yeare."', '".htmlspecialchars($_REQUEST['appoint'], ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['owners_name'], ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['contact_phone'], ENT_QUOTES)."', '".htmlspecialchars($_REQUEST['owners_car'], ENT_QUOTES)."', '".$recur."')";
	if($db->bb_query($new_event)){echo "<h2>Запись на диагностику/ремонт добавлена успешно!</h2>";}
$text_to_send = $daye .' '. $monthe .' '. $ora .' '. htmlspecialchars($_REQUEST['owners_car'], ENT_QUOTES) .' '. htmlspecialchars($_REQUEST['contact_phone'], ENT_QUOTES) .' '. htmlspecialchars($_REQUEST['owners_name'], ENT_QUOTES) .' ';

$sms_ru_user_id = '';
$sms_ru_user_phone = '';

$sms_body=file_get_contents('http://sms.ru/sms/send?api_id='.$sms_ru_user_id.'&to='.$sms_ru_user_phone.'&text='.urlencode(iconv('windows-1251','utf-8',$text_to_send)));
}
function upd_event(){
	$ora=$_REQUEST['hour'].":".$_REQUEST['minuts'];
	if($_REQUEST['day_app']=='0'){$daye=date('d');}else{$daye=$_REQUEST['day_app'];}
	if($_REQUEST['month_app']=='0'){$monthe=date("M");}else{$monthe=$_REQUEST['month_app'];}
	if($_REQUEST['year_app']=='0'){$yeare=date('Y');}else{$yeare=$_REQUEST['year_app'];}
	if(isset($_REQUEST['recur'])){$recur=$_REQUEST['recur'];}else{$recur=0;}
	$upd_event="UPDATE calendar SET ora_app='".$ora."', day='".$daye."', month='".$monthe."', year='".$yeare."', appointment='".htmlspecialchars($_REQUEST['appoint'], ENT_QUOTES)."', owners_name='".htmlspecialchars($_REQUEST['owners_name'], ENT_QUOTES)."', contact_phone='".htmlspecialchars($_REQUEST['contact_phone'], ENT_QUOTES)."', owners_car='".htmlspecialchars($_REQUEST['owners_car'], ENT_QUOTES)."', recurrence='".$recur."' WHERE id='".$_REQUEST['id']."' ";
	$db= new db;
	if($db->bb_query($upd_event)){echo "<h2>Запись на диагностику/ремонт обновлена</h2>";}
}
function del_event($id=''){
		$db= new db;
		$r_del="DELETE FROM calendar WHERE id='".$id."'";
		$delete=$db->bb_query($r_del);
		echo "<center><h4>Запись удаляется";
			echo "<br /><br />пожалуйста, ждите...</h4></center>";
			echo "<meta http-equiv=\"refresh\" content=\"1;	URL=".$_SERVER['PHP_SELF']."?act=agenda&month=".date("M")."&y=".date("Y")."\">";
		
}

// end of class
}
 ?> 
