<?
  if (file_exists("globals.php")) require_once("globals.php");
  else require_once("arhivaPhoto/globals.php");
  $link = new MySQLCon;
  $limit = 12;  
  if (isset($id)) {
    $result = mysql_query("SELECT * FROM subcategorii WHERE id=".$id);  
	if (!mysql_num_rows($result)) $id = 0;
  } else 
  if (isset($_REQUEST['id'])) {
    $result = mysql_query("SELECT * FROM subcategorii WHERE id=".$_REQUEST['id']);
	if (mysql_num_rows($result)) $id = $_REQUEST['id'];  
	else $id = 0;
  } else $id = 0;
  $spatiu = 0;
  echo "<br>";
  if (!isset($_REQUEST['nr'])) {
    if ($id) {
      $result = mysql_query("SELECT * FROM arhiva WHERE subcategorie=".$id." ORDER BY id ASC");
      $rows = mysql_num_rows($result);
      if ($rows) {
	    $result2 = mysql_query("SELECT * FROM subcategorii WHERE id=".$id);
		if (mysql_num_rows($result2)) {
		  $line = mysql_fetch_array($result2);
		  echo '<center>'.$line[2].'</center><br>';
		} else echo '<h2>Ismeretlen kategória. / Unidentified category.</h2>';
        for ($i = 0; $line = mysql_fetch_array($result); $i++) $array[$i] = $line;
        echo '<table border="0" cellspacing="0" cellpading="0"><tr><td><table width="100%" cellspan="0" colspan="0" border="0"><tr>';$contor = 0; $temp = 0;
	    for (reset($array); $line = current($array); next($array)) {	
			 $path = $_SERVER['DOCUMENT_ROOT']."/galerie/arhiva/".$line[4];
			 $image = getimagesize($path);
			 $latime = $image[0]; 
			$spatiu += $latime;
			 $contor = key($array);
			 
			 if (($contor % 3 == 0) && ($spatiu <= 520))
			 {		 
			   	if ($temp) {
			    echo '<td align="left" valign="bottom">'; 
				$temp = 0;
				}
				else  echo '<td align="left" valign="bottom">';
				  echo '
				  <table cellspan="0" colspan="0" border="0" bgcolor="#a0a0a0">
				  <tr><td width="'.$latime.'" align="left" class="textAlb"><a href="arhivaPhoto/show_photos.php?nr='.$line[0].'" target="_blank"><img class="contur" border="1" src="arhiva/'.$line[4].'" alt="'.$line[5].'"></a>
				   &nbsp;'.$line[6].'</td></tr></table></td>';
				  }
			  elseif (($contor % 3 == 1) && ($spatiu <= 520))			 
			  {
			    if ($temp) {
			    echo '<td align="left" valign="bottom">'; 
				$temp = 0; 
				}
				else  echo '<td align="right" valign="bottom">';
				  echo '<table cellspan="0" colspan="0" border="0" bgcolor="#a0a0a0">
				  <tr><td width="'.$latime.'" align="left" class="textAlb"><a href="arhivaPhoto/show_photos.php?nr='.$line[0].'" target="_blank"><img class="contur" border="1" src="arhiva/'.$line[4].'" alt="'.$line[5].'"></a>
				   &nbsp;'.$line[6].'</td></tr></table></td>';
			  }				   
			  elseif (($contor % 3 == 2) && ($spatiu <= 520))
			  {
				 if ($temp) {
			     echo '<td align="left" valign="bottom">'; 
				 $temp = 0; 
				 }
				 else  echo '<td align="right" valign="bottom">';
				  echo '
				  <table cellspan="0" colspan="0" border="0" bgcolor="#a0a0a0">
				  <tr><td width="'.$latime.'" align="left" class="textAlb"><a href="arhivaPhoto/show_photos.php?nr='.$line[0].'" target="_blank"><img class="contur" border="1" src="arhiva/'.$line[4].'" alt="'.$line[5].'"></a>
				   &nbsp;'.$line[6].'</td></tr></table></td></tr></table>';
				  echo '<tr><td><table width="100%" cellspan="0" colspan="0" border="0"><tr>';
				  $spatiu = 0;
				  $temp = 1;
				 }  
			  else { 
			  $spatiu = $latime;
			     echo '</tr></table><tr><td><table width="100%" cellspan="0" colspan="0" border="0"><tr>'; 
				 echo '<td align="left" valign="bottom">
				  <table cellspan="0" colspan="0" border="0" bgcolor="#a0a0a0">
				  <tr><td width="'.$latime.'" align="left" class="textAlb"><a href="arhivaPhoto/show_photos.php?nr='.$line[0].'" target="_blank"><img class="contur" border="1" src="arhiva/'.$line[4].'" alt="'.$line[5].'"></a>
				   &nbsp;'.$line[6].'</td></tr></table></td>';
				   $temp = 1;
				 }
			  // if  { $spatiu = 0 ; echo '<tr><table width="100%" cellspan="0" colspan="0" border="0"><tr>';}
			}
		echo '</td></tr></table><br>';
	} else echo "<h2>Nincsenek képek az adatbázisban. / No images in database.</h2>";
	  echo '<br><center><input type="button" value="<<<<" onClick="location.href=\'arhiva.php\'"></center>';
  } else {
	  $result = mysql_query("SELECT * FROM categorii ORDER BY id DESC");
	  if (mysql_num_rows($result)){
	    echo '<table width="100%" align="justify" cellSpacing="0" cellPadding="0">
		      <tr><td height="25">';
		while ($line = mysql_fetch_array($result)) {
		  $result2 = mysql_query("SELECT * FROM subcategorii WHERE categorie=".$line[0]." ORDER BY id DESC");
		  echo '&nbsp;&nbsp;<br><h2>'.$line[1].'</h2><br>';
		  while ($line2 = mysql_fetch_array($result2)) 
		    echo '&nbsp;&nbsp;&nbsp;<img src="arhivaPhoto/mini/mini_gri_porto.gif" width="12" height="14">&nbsp;<a href="arhiva.php?id='.$line2[0].'">'.$line2[2].'</a><br>';

		}
		echo '</td></tr></table>';
	  } else echo '<h2>Nincsenek képkategóriák. / No categories created.</h2>';
	}
  } else {
    $result = mysql_query("SELECT * FROM arhiva WHERE id=".$_REQUEST['nr']);
    if (mysql_num_rows($result)) {
	  $line = mysql_fetch_array($result);
	  echo '<center>
	        <table border="0" cellpadding="2" cellspacing="3">
	         <tr>
			  <td align="center">
			  <img src="../arhiva/'.$line[9].'" border="0">
			  </td>
			</table>
			</center>
			';	  
	} else header("Location: ../index.html");
  }
  
  $link->close();  
?>