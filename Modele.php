<?php

require "Compte.php";
require "Personne.php";

class Modele{

     private $pdo;

     function __construct(){
          $this->pdo = new PDO("mysql:host=localhost;dbname=banque", "root", "",
          [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
          ]);
          $this->pdo->exec("SET NAMES utf8");
     }

     public function getAllCompte(){
          //recupere les comptes et pour chaque
          $stmt = $this->pdo->prepare("SELECT * FROM compte");
          $stmt->execute();

          //array vide
          $comptes = [];

          //parcours le resultat de la requete
          while($res = $stmt->fetch()){
               //une instance de Compte
               $compte = new Compte($res);
               //ajout de compte dans l'array $comptes[]
               $comptes[] = $compte;
          }
          return $comptes;
     }

     public function addCompte(array $data){
          $compte = new Compte($data);

          $stmt = $this->pdo->prepare("INSERT INTO compte VALUES(NULL, ?, ?)");
          $stmt->execute( [$compte->getTitulaire(), $compte->getSolde()] );
          return $stmt;
     }

     public function deposer($ref, $montant){
          $compte = $this->getCompte($ref);
          $compte->deposer($montant);

          $stmt = $this->pdo->prepare("UPDATE compte SET solde = :solde WHERE reference = :ref");
          $stmt->execute( ["solde" => $compte->getSolde(), "ref" => $compte->getReference()] );

          // $stmt = $this->pdo->prepare("UPDATE compte SET solde = ? WHERE reference = ?");
          // $stmt->execute( [$montant, $ref] );
     }

     public function getCompte($referenceCompte){
          //RECUPERATION D'UN COMPTE'
          $stmt = $this->pdo->prepare("SELECT * FROM compte WHERE reference = ?");
          $stmt->execute([$referenceCompte]);
          $resultat = $stmt->fetch();

          $compte = new Compte($resultat);
         
          return $compte;
     }

     public function getTitulaire($id){
          //RECUPERATION D'UN TITULAIRE
          $stmt = $this->pdo->prepare("SELECT * FROM personne WHERE id = ?");
          $stmt->execute([$id]);
          $resultat = $stmt->fetch();

          $personne = new Personne($resultat);
         
          return $personne;
     }

     public function getTitulaires(){
          //RECUPERATION DES TITULAIRES
          $stmt = $this->pdo->prepare("SELECT * FROM personne");
          $stmt->execute();
          $personnes = [];
          while($resultat = $stmt->fetch()){
               $personnes[] = new Personne($resultat);
          }
          return $personnes;
     }
}