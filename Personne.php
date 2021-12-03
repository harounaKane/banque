<?php

class Personne{

     private $id;
     private $prenom;
     private $nom;

     public function __construct(array $data){
          foreach($data as $key => $value){
               $methode = "set".ucfirst($key);

               //on teste si le setter exist
               if( method_exists($this, $methode) ){
                    $this->$methode($value);
               }
          }
     }

     public function setId($id){
          $this->id= $id;
     }

     public function setPrenom($prenom){
          $this->prenom = $prenom;
     }

     public function setNom($nom){
          $this->nom = $nom;
     }

     public function getId(){return $this->id;}
     public function getPrenom(){return $this->prenom;}
     public function getNom(){return $this->nom;}

}