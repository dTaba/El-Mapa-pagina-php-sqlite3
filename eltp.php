<br />
<!doctype html>
<!-- userid: aa5569569647134e1ad4242d7fae0b35d48fa068 -->
<meta charset='utf-8'>
<style>

<?php

$DB_PATH = "mapa.sqlite3";

//Size de la tabla
$bloquesy = 16;
$bloquesx = 16;

$db_exists = file_exists($DB_PATH);


$db = new SQLite3($DB_PATH);
if (!$db_exists) {
	$query = file_get_contents("init.sql");
	$res = $db->exec($query);
	if (!$res) {
		die("error inicializando db");
  }
  
  for($i = 0; $i < $bloquesy; $i++)
  {
    for($z=0; $z < $bloquesx; $z++)
    {
      $db->exec("INSERT INTO celda(x,y,color) values (".$z.",".$i.",0)");
    }
  }
}

//Inicializo mis session
  session_start();
  if (!isset($_SESSION['Ypos']))
  {
    $_SESSION['Ypos'] = 5;
    $_SESSION['Xpos'] = 5;
    $_SESSION['colorselec'] = '0';
  }

  if (isset($_POST['color']))
  {
    $_SESSION['colorselec'] = $_POST['color'];
  }

?>
html, body {
	background-color: #444;
	color: white;
}

input[type=submit] {
	width: 32px;
	height: 32px;
}
td {
	padding: 2px;
	width: 30px;
	height: 30px;
	outline: 2px dotted transparent;

}

#moves, #colors, #datas {
	float: left;
	margin-left: 3em;
}

<?php
//Despues del post del usuario si trae color asigno a session de colorselec
for($j = 0; $j <= 15; $j++)
{
  if ($_SESSION['colorselec'] == $j)
  {
    $col[$j] = ", #plcol";
  }
  else
  {
    $col[$j]= "";
  }
}
?>

.col0 <?php echo $col[0] ?> { color: #000000; background: #000000; }
.bor0 { outline: dotted 2px #000000;}
.col1 <?php echo $col[1] ?> { color: #1D2B53; background: #1D2B53; }
.bor1 { outline: dotted 2px #1D2B53;}
.col2 <?php echo $col[2] ?> { color: #7E2553; background: #7E2553; }
.bor2 { outline: dotted 2px #7E2553;}
.col3 <?php echo $col[3] ?> { color: #008751; background: #008751; }
.bor3 { outline: dotted 2px #008751;}
.col4 <?php echo $col[4] ?> { color: #AB5236; background: #AB5236; }
.bor4 { outline: dotted 2px #AB5236;}
.col5 <?php echo $col[5] ?> { color: #5F574F; background: #5F574F; }
.bor5 { outline: dotted 2px #5F574F;}
.col6 <?php echo $col[6] ?> { color: #C2C3C7; background: #C2C3C7; }
.bor6 { outline: dotted 2px #C2C3C7;}
.col7 <?php echo $col[7] ?> { color: #FFF1E8; background: #FFF1E8; }
.bor7 { outline: dotted 2px #FFF1E8;}
.col8 <?php echo $col[8] ?> { color: #FF004D; background: #FF004D; }
.bor8 { outline: dotted 2px #FF004D;}
.col9 <?php echo $col[9] ?> { color: #FFA300; background: #FFA300; }
.bor9 { outline: dotted 2px #FFA300;}
.col10 <?php echo $col[10] ?> { color: #FFEC27; background: #FFEC27; }
.bor10 { outline: dotted 2px #FFEC27;}
.col11 <?php echo $col[11] ?> { color: #00E436; background: #00E436; }
.bor11 { outline: dotted 2px #00E436;}
.col12 <?php echo $col[12] ?> { color: #29ADFF; background: #29ADFF; }
.bor12 { outline: dotted 2px #29ADFF;}
.col13 <?php echo $col[13] ?> { color: #83769C; background: #83769C; }
.bor13 { outline: dotted 2px #83769C;}
.col14 <?php echo $col[14] ?> { color: #FF77A8; background: #FF77A8; }
.bor14 { outline: dotted 2px #FF77A8;}
.col15 <?php echo $col[15] ?> { color: #FFCCAA; background: #FFCCAA; }
.bor15 { outline: dotted 2px #FFCCAA;}



</style>
<h1>LA VACA LOCA</h1>



<?php




//Despues del post del usuario si trae move asigno a session de Ypos o Xpos
if (isset($_POST['move']))
{
  $letra = $_POST['move'];
  
  switch($letra)
  {
    case 'W':
      $_SESSION['Ypos']--;
      if($_SESSION['Ypos'] < 0)
      {
        $_SESSION['Ypos']= $bloquesy - 1;
      }
      break;
    case 'D':
      $_SESSION['Xpos']++;
      if($_SESSION['Xpos'] > $bloquesx -1)
      {
        $_SESSION['Xpos'] = 0;
      }
      break;
    case 'A':
      $_SESSION['Xpos']--;
      if($_SESSION['Xpos'] < 0)
      {
        $_SESSION['Xpos'] = $bloquesx -1;
      }
      break;
    case "S":
      $_SESSION['Ypos']++;
      if($_SESSION['Ypos'] >$bloquesy -1)
      {
        $_SESSION['Ypos'] = 0;
      }
      break;
    case "X":
      $db->query("UPDATE celda set color =".$_SESSION["colorselec"]." where x=".$_SESSION["Xpos"]." and y=".$_SESSION["Ypos"]);
      break;
  }
}

// //Debug
// mostrar($_POST);
// echo $_SESSION['colorselec'].'<br>';
// echo $_SESSION['Ypos'].'<br>';
// echo $_SESSION['Xpos'].'<br>';

?>

<table id="main">
  <?php


$results = $db->query("SELECT * from mapa");
//Creo la tabla
for($i = 0; $i < $bloquesy; $i++)
{
  echo"<tr>";
  for($z=0; $z < $bloquesx; $z++)
  {
    
    $row = $results->fetchArray(SQLITE3_ASSOC);
    
    if($row["x"] == $z and $row["y"] == $i)
    {
      $colorrow = $row["color"];
    }


    if($z == $_SESSION['Xpos'] and $i == $_SESSION['Ypos'])
    {
      echo"<td class='col".$colorrow." bor".$_SESSION['colorselec']."'></td>";
    }
    // elseif($_POST['move'] == 'X')
    // {
    //   echo"<td class=col".$_SESSION['colorselec']."></td>";
    // }
    else
    {
      echo"<td class=col".$colorrow."></td>";
    }
  }
}
  ?>
</table>

<form method="post" action="">
<div id="moves">
<h3> move </h3>
	<table>
		<tr>
			<td></td>
			<td><input type="submit" name="move" value="W"/></td>
			<td></td>
		</tr>
		<tr>
			<td><input type="submit" name="move" value="A"/></td>
			<td><input type="submit" name="move" value="X" id="plcol"/></td>
			<td><input type="submit" name="move" value="D"/></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="move" value="S"/></td>
			<td></td>
		</tr>
	</table>
	<h2> Posicion = <?php echo $_SESSION['Xpos']; ?> , <?php echo $_SESSION['Ypos']; ?> </h2>
</div>

<div id="colors">
	<h3> color </h3>
	<table>
    <tr><td><input type='submit' name='color' class='col0' value='0'/></td>
    <td><input type='submit' name='color' class='col1' value='1'/></td>
    <td><input type='submit' name='color' class='col2' value='2'/></td>
    <td><input type='submit' name='color' class='col3' value='3'/></td>
    <tr><tr><td><input type='submit' name='color' class='col4' value='4'/></td>
    <td><input type='submit' name='color' class='col5' value='5'/></td>
    <td><input type='submit' name='color' class='col6' value='6'/></td>
    <td><input type='submit' name='color' class='col7' value='7'/></td>
    <tr><tr><td><input type='submit' name='color' class='col8' value='8'/></td>
    <td><input type='submit' name='color' class='col9' value='9'/></td>
    <td><input type='submit' name='color' class='col10' value='10'/></td>
    <td><input type='submit' name='color' class='col11' value='11'/></td>
    <tr><tr><td><input type='submit' name='color' class='col12' value='12'/></td>
    <td><input type='submit' name='color' class='col13' value='13'/></td>
    <td><input type='submit' name='color' class='col14' value='14'/></td>
    <td><input type='submit' name='color' class='col15' value='15'/></td>
  </form>
<tr>		</tr>

  </table>
</div>
</form>
<?php

function mostrar($array)
{
  echo '<pre>';
  print_r($array);
  echo'</pre>';
}
?>