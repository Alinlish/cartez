<?php
session_start();
set_time_limit(0);
error_reporting(E_ALL);

// Informatii baza de date

 $AdresaBazaDate = "localhost";
 $UtilizatorBazaDate = "root";
 $ParolaBazaDate = "proiect";
 $NumeBazaDate = "librarie";

 $conexiune = mysql_connect($AdresaBazaDate,$UtilizatorBazaDate,$ParolaBazaDate) or die("Nu ma pot conecta la MySQL!");
 mysql_select_db($NumeBazaDate, $conexiune) or die("Nu gasesc baza de date");
 
?>