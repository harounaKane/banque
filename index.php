<?php

require "Modele.php";

$modele = new Modele();

$comptes = $modele->getAllCompte();
$personnes = $modele->getTitulaires();


//CREATION NEW COMPTE
if( isset($_POST['solde']) ){

     $modele->addCompte($_POST);

     header("location: .");
     exit;
//DEPOT     
}elseif( isset($_POST['deposer']) ){
     $modele->deposer($_POST['reference'], $_POST['montant']);
     header("location: .");
     exit;

}elseif( isset($_POST['virer']) ){
     extract($_POST);
     $modele->viverVers($reference, $montant, $destination);
     header("location: .");
     exit;

} elseif( isset($_GET['action']) ){
     $action = $_GET['action'];

     //DEPOT
     if( $action == "deposer" && ctype_digit($_GET['ref']) ){
          include "vues/deposer.phtml";
     }
     //VIRERVERS
     if( $action == "virer" && ctype_digit($_GET['ref']) ){
          $compteCourant = $modele->getCompte($_GET['ref']);
          include "vues/virer.phtml";
     }

}else{
     include "vues/compte.phtml";
}

