<?
$ROWS_PER_PAGE     = 14;
$RS_NAME           = "";
$ROOM_LEAP_TIME    = "12:00:00";

require_once("lib/setting.php");
$PID = "home";
$SC = $_SERVER["SCRIPT_NAME"];
session_start();

//set_time_limit(60);

if (isset($_GET["httpHeader"]) && file_exists("includes/".$_GET["p"].".php")) {
    include("includes/".$_GET["p"].".php");
    exit;
}

?>

<html>
<head>
<title><?=$set_client_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

    <SCRIPT language="JavaScript" src="menu_style.js"></SCRIPT>

<link href="css/template.css" rel="stylesheet" type="text/css" />
    <LINK rel='StyleSheet' type='text/css' href='default.css'>
    <LINK rel="stylesheet" type="text/css" href="menu.css">
    <LINK rel="stylesheet" type="text/css" href="tabbar.css">
    <LINK rel="icon" href="images/icon.png" type="image/png">
    <LINK rel="shortcut icon" href="images/icon.png" type="image/png">
    <SCRIPT language="JavaScript" src="lib/sjsm.js"></SCRIPT>
    
    <SCRIPT language="JavaScript" src="lib/date/CalendarPopup.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="lib/date/date.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="lib/date/AnchorPosition.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="lib/date/PopupWindow.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="plugin/prototype.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="plugin/scriptaculous.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="plugin/timeout.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript">
		var cal = new CalendarPopup();
	</SCRIPT>

</head>

<!-- <body bgcolor="#ffffff" onload="document.Form2.search.focus()"> -->
<body onload="init('<?php echo $set_base_url?>', '<?php echo $set_idle_time?>')" bgcolor="#ffffff">
<div id="LoadingDiv" style="display:none">
    <img src="<?php echo $set_base_url?>/plugin/ajax-loader.gif" align="absmiddle">
    Loading, please wait ...
</div>

<center>
<script language="JavaScript" src="menu.php"></script>
<script language="JavaScript">d.write(menu.sm)/*Menu inserted*/</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
  <tr valign="top">
    <td height="98%" align="center" >	 
	  <table width="100%" height="100%"  border="1" cellspacing="0" cellpadding="0" bgcolor="#ffffff" >
	   <tr >        
 
		<td  valign="absmiddle" >  

 		<!-- <img src="image/bg/rsau.gif" align="left"> -->
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right" >
  			<tr valign="middle" >
			<td rowspan="2" height="64" align="left" background="images/top.gif"><img src="<?=$set_client_logo?>" align="left" hspace="5" />
		          <font color=white>
					<div class="SUBTITLE_SIM" >&nbsp</div>
     			    <div class="TITLE_SIM_HEADER" ><?=$set_header[0]?></div>
					<div class="TITLE_SIM_HEADER"><?=$set_header[1]?></div>
					<div class="TITLE_SIM_HEADER"><?=$client_city?></div>
			 <td  height="64" align="left" background="images/top.gif"><img src="<?=$set_client_image?>" align="right"/>
 									
  			</td>
    		          

  			</tr>

			
		  </table>
		  
		</td>				
          </tr>	   	   
	  <!-- <tr><td align="center" valign="top"><img src="image/bg/bg.home.jpg" border="0" ></td></tr> -->
          <tr><TD bgcolor="#198D19" align="left"> <script language="Javascript">d.write(menu.m)/*Menu inserted*/</script></TD></tr>
	  <tr>
	  	<td>
	     	<!-- Main Application -->
			<TABLE border="0" width="100%" cellspacing="0" cellpadding="2" >
			<? 
			if ($_SESSION[uid]){
			?>
				<tr>
				<td class="SUBTITLE_SIM" align=left>Login  : <font color=#3a7301>[ <?=strtoupper($_SESSION[uid])?>]</font> - <?=$_SESSION[nama_usr]?>  </td>
				</tr>
				
				
			<? //} ?>
                    <TR><TD>
			<?
			if (isset($_GET[p]) && file_exists("includes/".$_GET["p"].".php")) {
				include("includes/".$_GET["p"].".php");
				//echo "<tr><td><font FACE='georgia' color='RED'><center><blink><B>PERHATIAN!</B></blink><center></font></td></tr>";
				//echo "<tr><td><font color='RED' size='2px'><marquee onmouseover='this.stop()' onmouseout='this.start()' scrollamount='2' direction='left'>Hati-hati dalam melakukan proses penginputan data, KODE/NAMA LAYANAN dan YANG MELAKUKAN TINDAKAN wajib diisi. Terima kasih.</font></td></tr>";
			} elseif (empty($_SESSION[uid])) {
				include("login/index.php");
			} else {
				//echo "<img src=\"images/spacer.gif\" border=0 width=1 height=150><br>";
				echo "<tr>";
			echo "<td>&nbsp</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>&nbsp</td>";
			echo "</tr>";
				echo "<tr>";
				echo "<td width=10% align=center height=70><a href=\"index2.php?p=720\" onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('daftar','','icon/daftar-2.gif',1)><img name=\"daftar\" border=0 src=\"icon/patient_info-icon.gif\"></a></td>";															
				echo "<td width=10% align=center height=70><a href=\"index2.php?p=730\" onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('daftar','','icon/daftar-2.gif',1)><img name=\"daftar\" border=0 src=\"icon/hospital-icon.gif\"></a></td>";
				echo "<td width=10% align=center height=70><a href=\"index2.php?p=740\" onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('daftar','','icon/daftar-2.gif',1)><img name=\"daftar\" border=0 src=\"icon/medical_insurance-icon.gif\"></a></td>";		
				echo "<td width=10% align=center height=70><a href=\"index2.php?p=405\" onMouseOut=MM_swapImgRestore() onMouseOver=MM_swapImage('daftar','','icon/daftar-2.gif',1)><img name=\"daftar\" border=0 src=\"icon/surgeon-icon.gif\"></a></td>";	
				echo "";	
				echo "</tr>";	
				echo "<tr valign=top align=center class=font01>";
    		  	echo "<td>Info Pasien</td>";
    		  	echo "<td>Info Bangsal </td>";
  			 	echo "<td>Info Tarif</td>";
			  	echo "<td>Pasien Rawat Inap</td>";
  			echo "</tr>";
			echo "<tr>";
			echo "<td>&nbsp</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>&nbsp</td>";
			echo "</tr>";
			echo "<tr>";
			echo "</tr>";
			
			

			//	echo "<img name=\"daftar\" border=0 src=\"icon/rawat-inap.gif\"><br></div>";								
			//	echo "<div align=center><font class=form_title>".strtoupper($_SESSION[uid])." siap beroperasi.";

				//echo "<br>Pilih menu di atas.</font></div>";
				
			}
                        }else{
			echo "<script language='JavaScript'>document.location='index.php'</script>";
			}
			?>
					
			</TD>
			</TR>
			<TR>
			  <TD colspan="4" align="center"></TD>
			  </TR>
			
			</TABLE>
			
	     </td>
	</tr>
        <tr valign="middle" >
			<td  height="56" align="right" bgcolor="#198D19">
			        <font color=white>
					<div class="SUBTITLE_SIM_FOOTER" >&nbsp</div>
					<div class="SUBTITLE_SIM_FOOTER" ><?=$set_copy?></div>
					<div class="SUBTITLE_SIM_FOOTER" ><?=$set_man?></div>
		
			
 									
  			</td>
    		          

  			</tr>
      </table>
</td>
</tr>
 </table>

<p>&nbsp;</p>
</center>
 
</body>
</html>
