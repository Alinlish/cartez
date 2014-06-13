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
      <a href="profil.php"><strong id="alb_mic">Modificaţi date personale</strong></a><br /><br /> 
	  <a href="iesire.php"><strong id="alb_mic">Ieşire</strong></a>';
}
else
echo '<form action="index.php?actiune=validare" method="post">
	 <p align="center" id="alb_jos"><strong>Autentificare :</strong><br />
      E-mail :
	  <input type="text" name="e_mail" value="" /><br />
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
$cerereSQL = "SELECT * FROM `useri` WHERE e_mail='".htmlentities($_POST['e_mail'])."' AND parola='".md5($_POST['parola'])."'";
$rezultat = mysql_query($cerereSQL);
if(mysql_num_rows($rezultat) == 1)
{
  while($rand = mysql_fetch_array($rezultat))
  {
    $_SESSION['logat'] = 'Da';
    echo '<br /><strong id="alb_mic">Bine ai venit!</strong><br /><br /><br />
      <a href="profil.php"><strong id="alb_mic">Modificaţi date personale</strong></a><br /><br /> 
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
if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';

if($_SESSION['logat'] != 'Da') 
{
echo '<br /><br /><br /><h3>Nu puteţi accesa această pagină fără a fi logat. </h3><br /><br />
      <p id="albastru2">&nbsp;&nbsp;&nbsp;<a href="index.php">Logaţi-vă !</a></p><br /><br />
	  <p id="albastru3">&nbsp;&nbsp;&nbsp;<a href="inregistrare.php">Înregistraţi-vă !</a></p>';
}
else
{
switch($_GET['action'])
{
case '':

if($_SESSION['e_mail']=="administrator")

 echo '<br /><br /><br /><h3>Sunteţi administrator !</h3><br /><br />
 	  <a href="profil.php?action=date_personale">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Schimbaţi date !</p></a><br />
	  <a href="profil.php?action=parola_noua">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Schimbaţi parola !</p></a><br />
      <a href="profil.php?action=adauga_carti">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Adaugaţi cărţi !</p></a><br />
	  <a href="profil.php?action=modifica_carti">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Modificaţi cărţi !</p></a><br />
	  <a href="profil.php?action=sterge_carti">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Ştergeţi cărţi !</p></a><br />
	  <a href="profil.php?action=sterge_useri">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Ştergeţi Useri !</p></a>';
else echo '<br /><br /><br /><h3>Puteţi schimba datele din profilul dumneavoastră.</h3><br /><br />
      <a href="profil.php?action=date_personale">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Schimbaţi date !</p></a><br />
	  <a href="profil.php?action=parola_noua">
	  <p id="albastru">&nbsp;&nbsp;&nbsp;Schimbaţi parola !</p></a>';
break;

case 'date_personale':
   $cerereSQL = 'SELECT * FROM `useri` WHERE e_mail="'.$_SESSION['e_mail'].'"'; 
   $rezultat = mysql_query($cerereSQL);
   while($rand = mysql_fetch_array($rezultat))
   {
echo '<form name="formular" action="profil.php?action=datele" method="post" class="inregistrare">
	<div class="catedoua"></div>
    <div class="inregistreazate">Modificaţi date personale :</div>
	<div class="catedoua"></div>
<div class="catedoua">Introduceţi Nume :         
    <input type="text" name="nume" value="'.$rand['nume'].'" size="33" />  </div>
<div class="catedoua">Introduceţi Prenume :
	<input type="text" name="prenume" value="'.$rand['prenume'].'" size="33" /></div>
<div class="catedoua">Cod Numeric Personal :
	<input type="text" size="33" maxLength="13" name="cnp" value="'.$rand['cnp'].'" /></div>
<div class="catedoua">Introduceţi Adresa :
	<input type="text" name="adresa" value="'.$rand['adresa'].'" size="45" /> </div>
<div class="catedoua">Introduceţi Telefon :
	<input type="text" name="telefon" value="'.$rand['telefon'].'" size="33" /></div>
	<div class="catedoua"></div>
<div class="catedoua">
	<input name="Trimite" type="submit" id="Trimite" value="Modifica date" />
	<input name="Reseteaza" type="reset" id="Reseteaza" value="Reseteaza" /></div>
	<div class="catedoua"></div>
<div class="catedoua">
	<p id="albastru"><a href="profil.php">Înapoi</a></p></div>
    </form>';
}
break;


case 'datele':
$_SESSION['nume'] = $_POST['nume'];
$_SESSION['prenume'] = $_POST['prenume'];
$_SESSION['cnp'] = $_POST['cnp'];
$_SESSION['adresa'] = $_POST['adresa'];
$_SESSION['telefon'] = $_POST['telefon'];

if(($_POST['Trimite'] != 'Modifica date') && ($_SESSION['nume'] == '' || $_SESSION['prenume'] == '' || !is_numeric($_SESSION['cnp']) || strlen($_SESSION['cnp'] != 13) || $_SESSION['adresa'] == '' || !is_numeric($_SESSION['telefon']) || $_SESSION['telefon'] == ''))
{
echo '<br /><br /><br /><h3> Cîmpurile nu au fost completate corect !</h3><br /><br /><br />
      <a href="profil.php?action=date_personale">
	  <p id="albastru">Înapoi</p></a>';
}
elseif(($_POST['Trimite'] == 'Modifica date') && ($_SESSION['nume'] != '' || $_SESSION['prenume'] != '' || $_SESSION['cnp'] != '' || is_numeric($_SESSION['cnp']) || strlen($_SESSION['cnp'] != 13) || $_SESSION['adresa'] != '' || $_SESSION['telefon'] != ''))
{
echo '<br /><br /><br /><h3>Datele au fost modificate ! </h3><br /><br />
      <a href="profil.php"><p id="albastru">Înapoi la pagina principală.</p></a>';
$cerereSQL = "UPDATE `useri` SET nume='".($_SESSION['nume'])."', prenume='".($_SESSION['prenume'])."', cnp='".($_SESSION['cnp'])."', adresa='".($_SESSION['adresa'])."', telefon='".($_SESSION['telefon'])."' WHERE e_mail='".$_SESSION['e_mail']."'";
mysql_query($cerereSQL);	
}
break;

case 'parola_noua':

echo '<form name="formular" action="profil.php?action=validare_parola" method="post" class="inregistrare">
	<div class="catedoua"></div>
    <div class="inregistreazate">Modificaţi parola :</div>
	<div class="catedoua"></div>
	<div class="catedoua"></div>
<div class="catedoua">Introduceţi Parola :         
    <input type="password" name="parola" value="" />  </div>
<div class="catedoua">Introduceţi Parola nouă :
	<input type="password" name="parolab" value="" /></div>
<div class="catedoua"></div>
<div class="catedoua"></div>
	<div class="catedoua"></div>
<div class="catedoua">
	<input name="Trimite" type="submit" id="Trimite" value="Modifica parola" size="24" />
	<input name="Reseteaza" type="reset" id="Reseteaza" value="Resetează" size="24" /></div>
	<div class="catedoua"></div>
<div class="catedoua">
	<p id="albastru"><a href="profil.php">Înapoi</a></p></div>
    </form>';
break;

case 'validare_parola':

$_SESSION['parola'] = md5($_POST['parola']);
$_SESSION['parolab'] = md5($_POST['parolab']);

if(($_POST['Trimite'] == 'Modifica parola') && ($_SESSION['parola'] == '' || $_SESSION['parolab'] == $_SESSION['parola'] || $_SESSION['parolab'] == ''))
{
echo '<br /><br /><br /><h3>Parola nu a fost completată corect !</h3><br /><br />
      <a href="profil.php?action=parola_noua">
	  <p id="albastru">Înapoi</p></a>';
}
elseif(($_POST['Trimite'] == 'Modifica parola') && ($_SESSION['parola'] != '' || $_SESSION['parolab'] != $_SESSION['parola']))
{
echo '<br /><br /><br /><h3>Parola a fost modificată ! </h3><br /><br />
      <a href="profil.php">
	  <p id="albastru">Înapoi la pagina principală</p></a>';
$cerereSQL = "UPDATE `useri` SET parola='".($_SESSION['parolab'])."' WHERE e_mail='".$_SESSION['e_mail']."'";
mysql_query($cerereSQL);	
}

break;

case 'adauga_carti':
   echo '<form name="formular" action="profil.php?action=adaugare_carti" method="post" class="inregistrare">
	<div class="catedoua"></div>
    <div class="inregistreazate">Adaugaţi cărţi</div>
	<div class="catedoua"></div>
<div class="catedoua">Introduceţi Titlu :         
    <input type="text" name="titlu" value="" size="33" />  </div>
<div class="catedoua">Introduceţi Autor :
	<input type="text" name="autor" value="" size="33" /></div>
<div class="catedoua">Introduceti editura :
	<input type="text" size="33" name="editura" value="" /></div>
<div class="catedoua">Introduceţi Pret :
	<input type="text" name="pret" value="" size="33" /></div>
<div class="catedoua">Introduceţi Categorie :
	<input type="text" name="categorie" value="" size="33" /></div>
	<div class="catedoua"></div>
<div class="catedoua">
	<input name="Trimite" type="submit" id="Trimite" value="Trimite" />
	<input name="Reseteaza" type="reset" id="Reseteaza" value="Resetează" /></div>
    <div class="catedoua">
	<p id="albastru"><a href="profil.php">Înapoi</a></p></div>
	</form>';
break;

case 'adaugare_carti':

$_SESSION['titlu'] = $_POST['titlu'];
$_SESSION['autor'] = $_POST['autor'];
$_SESSION['editura'] = $_POST['editura'];
$_SESSION['pret'] = $_POST['pret'];
$_SESSION['categorie'] = $_POST['categorie'];


if(($_SESSION['titlu'] == '') || ($_SESSION['autor'] == '') || ($_SESSION['editura'] =='' || ($_SESSION['pret'] == '') || ($_SESSION['categorie'] == '')))
{
echo '<p id="albastru">&nbsp;&nbsp;&nbsp;Cărtile introduse nu sunt complete sau corecte.</p><br />
<p id="albastru">&nbsp;&nbsp;&nbsp;Pentru a reveni acasa apasaţi <a href="profil.php">aici</a></p><br />.';
} 
else 
{
echo '<p id="albastru">&nbsp;&nbsp;&nbsp;Cărtile au fost adăugate cu succes.</p>
	<p id="albastru">&nbsp;&nbsp;&nbsp;Pentru a reveni apasaţi <a href="profil.php">aici</a></p><br />';

$cerereSQL = "INSERT INTO `carti` (`titlu`, `autor`, `editura`, `pret`, `categorie`)
	          VALUES ('".htmlentities($_SESSION['titlu'])."', '".htmlentities($_SESSION['autor'])."', '".htmlentities($_SESSION['editura'])."', '".htmlentities($_SESSION['pret'])."', '".htmlentities($_SESSION['categorie'])."')";
mysql_query($cerereSQL);
}

break;
case 'modifica_carti':

if(isset($_GET['id']))
	$cerereSQL = 'SELECT * FROM `carti` WHERE `id_carte`='.$_GET['id'].'';
else
	$cerereSQL = 'SELECT * FROM `carti`';
   $rezultat = mysql_query($cerereSQL);
   while($rand = mysql_fetch_array($rezultat))
   {
echo '<form name="formular" action="profil.php?action=modifica_carte" method="post" class="modisterg">
    <div class="modititlu">Modificaţi carte :</div>
	<div class="douamodi"></div>
<div class="douamodi">Introduceţi Titlu :         
    <input type="text" name="titlu" value="'.$rand['titlu'].'" size="20" />  </div>
<div class="douamodi">Introduceţi Autor :
	<input type="text" name="autor" value="'.$rand['autor'].'" size="20" /></div>
<div class="douamodi">Introduceti Editura :
	<input type="text" size="20"name="editura" value="'.$rand['editura'].'" /></div>
<div class="douamodi">Introduceţi Pret :
	<input type="text" name="pret" value="'.$rand['pret'].'" size="20" /> </div>
<div class="douamodi">Introduceţi Categorie :
	<input type="text" name="categorie" value="'.$rand['categorie'].'" size="20" /></div>
	<input type="hidden" name="id" value="'.$rand['id_carte'].'" />
<div class="douamodi">
	<input name="trimite" type="submit" id="trimite" value="Modifică carte" />
	<input name="reseteaza" type="reset" id="reseteaza" value="Resetează" /></div>
    </form>';
}
break;

case 'modifica_carte':

if(isset($_POST['trimite']))
	$id = $_POST['id'];
	$titlu = $_POST['titlu'];
	$autor = $_POST['autor'];
	$editura = $_POST['editura'];
	$pret = $_POST['pret'];
	$categorie = $_POST['categorie'];


$cerereSQL = "UPDATE `carti` SET `titlu`='$titlu', `autor`='$autor', `editura`='$editura', `pret`='$pret', `categorie`='$categorie' WHERE `id_carte`='$id'";

if(mysql_query($cerereSQL))
echo '<br /><br /><br /><h3>Cartile au fost modificate ! </h3><br /><br />
      <p id="albastru"><a href="profil.php">Înapoi la pagina principală.</a></p>';	


break;

case 'sterge_carti':
if(isset($_GET['id']))
	$cerereSQL = 'SELECT * FROM `carti` WHERE `id_carte`='.$_GET['id'].'';
else
	$cerereSQL = 'SELECT * FROM `carti`';
   $rezultat = mysql_query($cerereSQL);
   while($rand = mysql_fetch_array($rezultat))
   {
echo '<form name="formular" action="profil.php?action=sterge_carte" method="post" class="modisterg">
    <div class="modititlu">Doriţi să ştergeţi cartea?</div>
	<div class="douamodi"></div>
<div class="douamodi">Introduceţi Titlu :         
    <input type="text" name="titlu" value="'.$rand['titlu'].'" size="20" />  </div>
<div class="douamodi">Introduceţi Autor :
	<input type="text" name="autor" value="'.$rand['autor'].'" size="20" /></div>
<div class="douamodi">Introduceti Editura :
	<input type="text" size="20"name="editura" value="'.$rand['editura'].'" /></div>
<div class="douamodi">Introduceţi Pret :
	<input type="text" name="pret" value="'.$rand['pret'].'" size="20" /> </div>
<div class="douamodi">Introduceţi Categorie :
	<input type="text" name="categorie" value="'.$rand['categorie'].'" size="20" /></div>
	<input type="hidden" name="id" value="'.$rand['id_carte'].'" />
<div class="douamodi">
	<input name="trimite" type="submit" id="trimite" value="Şterge carte" />
	<input name="reseteaza" type="reset" id="reseteaza" value="Resetează" /></div>
	</form>';
}
break;

case 'sterge_carte':
if(isset($_POST['trimite']))
	$id = $_POST['id'];
	
$cerereSQL = "DELETE FROM `carti` WHERE `id_carte`= $id";
if(mysql_query($cerereSQL))
	echo '<br /><br /><br /><h3>Cartea a fost ştearsă ! </h3><br /><br />
      <p id="albastru"><a href="profil.php">Înapoi la pagina principală.</a></p>';


break;

case 'sterge_useri':

	$cerereSQL = 'SELECT * FROM `useri`';
	if($rezultat = mysql_query($cerereSQL))
	 while($rand = mysql_fetch_array($rezultat))
echo '<form name="formular" action="profil.php?action=sterge_user" method="post" class="modisterg">
    <div class="modititlu">Ştergeţi Utilizator :</div>
	<div class="douamodi"></div>
<div class="douamodi">Introduceţi Nume:
    <input type="text" name="nume" value="'.$rand['nume'].'" size="20" />  </div>
<div class="douamodi">Introduceţi Prenume :
	<input type="text" name="prenume" value="'.$rand['prenume'].'" size="20" /></div>
<div class="douamodi">Cod Numeric Personal :
	<input type="text" size="20" maxlength="13" name="cnp" value="'.$rand['cnp'].'" /></div>
<div class="douamodi">Introduceţi Adresa :
	<input type="text" name="adresa" value="'.$rand['adresa'].'" size="20" /> </div>
<div class="douamodi">Introduceţi Telefon :
	<input type="text" name="telefon" value="'.$rand['telefon'].'" size="20" /></div>
	<input type="hidden" name="id" value="'.$rand['id_user'].'" />
<div class="douamodi">
	<input name="Trimite" type="submit" id="Trimite" value="Sterge Utilizatori" />
	<input name="Reseteaza" type="reset" id="Reseteaza" value="Reseteaza" /></div>
    </form>';
break;

case 'sterge_user':

	if(isset($_POST['id']))
	$id=$_POST['id'];
	$cerereSQL = 'DELETE FROM `useri` WHERE `id_user` = "'.$id.'"';
	if(mysql_query($cerereSQL))
		echo '<br /><br /><br /><p id="albastru">Utilizatorul a fost sters din baza de date.</p><br />
		<p id="albastru"><a href="profil.php">Înapoi la pagina principală.</a></p>';
	
break;

}
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
