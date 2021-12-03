<?php

class Compte{

     private $reference;
     private $titulaire;
     private $solde;

     private static $compteur = 100;
     public const TYPE = "compte courant"; 

     public function __construct(array $data){

          foreach($data as $key => $value){
               $methode = "set".ucfirst($key);

               //on teste si le setter exist
               if( method_exists($this, $methode) ){
                    $this->$methode($value);
               }
          } 
     }

     public static function nombreDeCompte(){
          return self::$compteur;
     }

     public function deposer(float $montant){
          //$this->solde = $this->solde + $montant;
          $this->solde += $montant;
     }

     public function retirer(float $montant){
          //$this->solde = $this->solde - $montant;
          $this->solde -= $montant;
     }

     public function virerVers(float $montant, Compte $compteDest){
          $this->retirer($montant);
          $compteDest->deposer($montant);
     }

     function afficher(){
          echo "ref: " . $this->reference ." titulaire: ". $this->titulaire ." solde: " . $this->solde;
     }

     //getter
     public function getReference(){
          return $this->reference;
     }

     public function getTitulaire(){
          return $this->titulaire;
     }
     public function getSolde(): float{
          return $this->solde;
     }

     //setter
     public function setReference(int $ref){
          $this->reference = $ref;
     }

     public function setTitulaire($titulaire){
          $this->titulaire = $titulaire;
     }

     public function setSolde(float $montant){
          $this->solde = $montant;
     }


}

