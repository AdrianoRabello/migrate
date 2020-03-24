
<?php

class Modalidade extends Record{

  const TABLENAME = 'modalidade';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Modalidade');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      $objeto->idAntigo   = $value->id;
      $objeto->aplicara   = $value->aplicara;
      $objeto->tiva       = $value->ativa;
      $objeto->nome       = $value->nome;
      $objeto->idadecorte = $value->idadedecorte;
     
     $objeto->post("http://localhost:8012/saaf/migrate/modalidade");

      //print_r($objeto);
      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Modalidade');
    $response = $repository->load($criteria);    
    print_r($response);
  }

}