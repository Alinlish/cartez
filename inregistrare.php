<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Libraria Cartez</title>
  <link href="stil.css" rel="stylesheet" type="text/css" />

 </head>
    
  <body class="twoColFixLtHdr">
  <div id="autentifica">
  <?php	
require_once('config.php');

if(!isset($_GET['actiune'])) $_GET['actiune'] = '';

switch($_GET['actiune'])
{
case '':

if(isset($_SESSION['logat']) && ($_SESSION['logat'] == 'Da')) 
{
	echo '<br /><strong id="alb_mic">Bine ai venit!</strong><br /><br /><br />
      <a href="profil.php"><strong id="alb_mic">Modifică date personale</strong></a><br /><br /> 
	  <a href="iesire.php"><strong id="alb_mic">Ieşire</strong></a>';
}
else
echo '<form action="index.php?actiune=validare" method="post">
	  <p align="center" id="alb_jos"><strong>Autentificare :</strong><br />
      E-mail :
	  <input type="text" name="e_mail" value=""/><br />
      Parolă :
	  <input type="password" name="parola" value="" /><br />
	  <input type="submit" name="Login" value="Logare" /><br /><br />
	   <a href="inregistrare.php" id="alb_jos2">Înregistrează-te</a></p>
	  </form>';
break;


case 'validare':

$_SESSION['e_mail'] = $_POST['e_mail'];

if(($_POST['e_mail'] == '') || ($_POST['parola'] == ''))
{
echo '<br /><br /><br /><p id="alb_mic">Datele de logare nu au fost completate.</p>
      <a href="index.php"><strong id="alb_jos">Înapoi</strong></a>';
}
else
{
$cerereSQL = "SELECT * FROM `useri` WHERE e_mail='".($_POST['e_mail'])."' AND parola='".($_POST['parola'])."'";
$rezultat = mysql_query($cerereSQL);
if(mysql_num_rows($rezultat) == 1)
{
  while($rand = mysql_fetch_array($rezultat))
  {
    $_SESSION['logat'] = 'Da';
    echo '<br /><strong id="alb_mic">Bine ai venit!</strong><br /><br /><br />
      <a href="profil.php"><strong id="alb_mic">Modifică date personale</strong></a><br /><br /> 
	  <a href="iesire.php"><strong id="alb_mic">Ieşire</strong></a>';
  }
}
else
{
echo '<br /><br /><br /><p id="alb_mic">Datele de logare sunt incorecte. </p>
      <a href="index.php"><strong id="alb_jos">Înapoi</strong></a>';
}

}}
?>
</div>
  
  <div id="newsletter">
 <?php 
require_once('config.php');

if(!isset($_SESSION['Nume'])) $_SESSION['Nume'] = '';
if(!isset($_SESSION['email'])) $_SESSION['email'] = '';

if (!isset($_GET['newsletter']))
echo '<form name="formular" action="index.php?newsletter=newsletter" method="post" >
		<p align="center" id="alb_jos3"><strong>Abonare newsletter :</strong>
            Nume :
                <input name="nume" type="text" value="'.$_SESSION['Nume'].'" />
              <br />
             E-mail :
                <input name="email" type="text" value="'.$_SESSION['email'].'"/><br /><br />
                <input type="submit" name="Trimite" value="Abonare"/></p>
    </form>';
elseif($_GET['newsletter']=='newsletter')
{

if(($_POST['nume'] == '') || ($_POST['email'] == ''))
{
echo '<br /><strong id="alb_mic">Nu aţi introdus datele !</strong>
      <br /><strong id="alb_mic">Pentru a reveni apăsaţi <a href="index.php">aici.</strong></a><br />';
} 
else 
{

echo '<br /><strong id="alb_mic">V-aţi abonat cu succes la newsletter !</strong>
      <br /> <a href="index.php"><strong id="alb_mic">Inapoi</strong></a><br />';

$cerereSQL = "INSERT INTO `newsletter` (`Nume`, `email`)
	          VALUES ('".$_POST['nume']."', '".$_POST['email']."')";
mysql_query($cerereSQL);
$email = $_POST['email'];
$subiect = "Newsletter";
$mesaj = "V-ati abonat cu succes la newsletter-ul librarieri online Cartez.";
$header = "Libraria Cartez";
	if (mail($email, $subiect, $mesaj, $header))
  		echo '
		<strong id="alb_mic">Pe adresa specificată v-a fost trimis un e-mail de înştiinţare!</strong>';

}
}
?>
  </div>
  
  <?php include ('informati.html'); ?>
  
  <div id="container">
    <div><img src="Images/librarie.gif" width="1004" alt="Librarie" />    </div>
    <?php include ('meniusus.html'); ?>
    <div id="cauta"><?php
	
     echo' <form name="cauta" action="cauta.php" method="post">
	<strong>Căutare carte : &nbsp;</strong>
	 <input name="searchTxt" value="" type="text" id="culoare_box" /> &nbsp;
      <select name="searchBy" id="culoare_box2">
        <option label="Căutare după" value="toate">Căutare după toate</option>
        <option label="Titlu" value="titlu">Titlu</option>
        <option label="Autor" value="autor">Autor</option>
        <option label="Editura" value="editura">Editură</option>
      </select>
	  <input type="submit" value="Caută" /> 
	 
	  <img src="Images/dungaalba.gif" alt="Albastru" />
      <i id="alb"><a href="cos_cumparaturi.php?cos=vizualizeaza">Coş Cumpărături</a></i>
      (conţine <i id="alb2">
        <a href="cos_cumparaturi.php?cos=vizualizeaza">';
		if(!isset($_SESSION['nr']))
			{
				$nr=0;
				echo $nr;
			}
		else
			echo $_SESSION['nr'];
		
		
		echo'</a> </i>produse)
		</form>';
    ?>
    </div>
    <?php include ('meniustanga.html'); ?>
    <div id="mainContent">
    &nbsp;&nbsp;&nbsp;&nbsp;
<?php 
require_once('config.php');

if(!isset($_GET['action'])) $_GET['action'] = '';
if(!isset($_SESSION['nume'])) $_SESSION['nume'] = '';
if(!isset($_SESSION['prenume'])) $_SESSION['prenume'] = '';
if(!isset($_SESSION['cnp'])) $_SESSION['cnp'] = '';
if(!isset($_SESSION['e_mail'])) $_SESSION['e_mail'] = '';
if(!isset($_SESSION['parola'])) $_SESSION['parola'] = '';
if(!isset($_SESSION['adresa'])) $_SESSION['adresa'] = '';
if(!isset($_SESSION['telefon'])) $_SESSION['telefon'] = '';

switch($_GET['action'])
{
case '':
echo '<form name="formular" action="inregistrare.php?action=inreg" method="post" class="inregistrare">
	<div class="catedoua"></div>
    <div class="inregistreazate">Înregistrează-te :</div>
	<div class="catedoua"></div>
<div class="catedoua">Introduceţi Nume :         
    <input type="text" name="nume" value="'.$_SESSION['nume'].'" size="33" />  </div>
<div class="catedoua">Introduceţi Prenume :
	<input type="text" name="prenume" value="'.$_SESSION['prenume'].'" size="33" /></div>
<div class="catedoua">Cod Numeric Personal :
	<input type="text" size="33" maxlength="13" name="cnp" value="'.$_SESSION['cnp'].'" /></div>
<div class="catedoua">Introduceţi E-mail :
	<input type="text" name="e_mail" value="'.$_SESSION['e_mail'].'" size="33" /></div>
<div class="catedoua">Introduceţi Parola :
	<input type="password" name="parola" value="'.$_SESSION['parola'].'" size="33" /></div>
<div class="catedoua">Introduceţi Adresa :
	<input type="text" name="adresa" value="'.$_SESSION['adresa'].'" size="45" /> </div>
<div class="catedoua">Introduceţi Telefon :
	<input type="text" name="telefon" value="'.$_SESSION['telefon'].'" size="33" /></div>
	<div class="catedoua"></div>
<div class="catedoua">
	<input name="Trimite" type="submit" id="Trimite" value="Trimite" />
	<input name="Reseteaza" type="reset" id="Reseteaza" value="Resetează" /></div>
    <div class="catedoua">
	<p id="albastru"><a href="index.php">Înapoi</a></p></div>
	</form>';
break;

case 'inreg':

$_SESSION['nume'] = $_POST['nume'];
$_SESSION['prenume'] = $_POST['prenume'];
$_SESSION['cnp'] = $_POST['cnp'];
$_SESSION['e_mail'] = $_POST['e_mail'];
$_SESSION['parola'] = $_POST['parola'];
$_SESSION['adresa'] = $_POST['adresa'];
$_SESSION['telefon'] = $_POST['telefon'];


if(($_SESSION['nume'] == '') || ($_SESSION['prenume'] == '') || ($_SESSION['cnp'] =='' || ($_SESSION['e_mail'] == '') || ($_SESSION['parola'] == '') || ($_SESSION['adresa'] == '') || (!is_numeric($_SESSION['telefon'])) || (strlen($_SESSION['cnp']) != 13)))
{
echo '<p id="albastru">&nbsp;&nbsp;&nbsp;Datele introduse nu sunt complete sau corecte.</p><br />
<p id="albastru">&nbsp;&nbsp;&nbsp;Pentru a reveni acasa apasaţi <a href="inregistrare.php">aici</a></p><br />.';
} 
else 
{
echo '<p id="albastru">&nbsp;&nbsp;&nbsp;Înregistrarea dumneavoastră a avut loc cu succes.</p>
	<p id="albastru">&nbsp;&nbsp;&nbsp;Pentru a reveni apasaţi <a href="index.php">aici</a></p><br />';

$cerereSQL = "INSERT INTO `useri` (`nume`, `prenume`, `cnp`, `e_mail`, `parola`, `adresa`, `telefon`)
	          VALUES ('".htmlentities($_SESSION['nume'])."', '".htmlentities($_SESSION['prenume'])."', '".htmlentities($_SESSION['cnp'])."', '".htmlentities($_SESSION['e_mail'])."', '".md5($_SESSION['parola'])."', '".htmlentities($_SESSION['adresa'])."', '".htmlentities($_SESSION['telefon'])."')";
mysql_query($cerereSQL);
}

break;

}

?>
   </div>
    <br class="clearfloat" />
   <div id="footer">
      <h2 class="offleft">Footer</h2>
      <p id="footerr"> @ 2009 Librăria Cartez. Toate drepturile rezervate
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
    <a href="http://validator.w3.org/check?uri=referer"><img
        src="http://www.w3.org/Icons/valid-xhtml10-blue"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
    
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
    <img style="width:88px;height:31px"
        src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
        alt="Valid CSS!" /></a>
    
    <a href="http://csac.ulbsibiu.ro"><img src="Images/csac.gif" alt="C.S.A.C." height="31" width="88" /></a></p>
    </div> 
</div>
  </body>
  </html>