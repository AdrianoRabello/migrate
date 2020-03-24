
<?php

class Obm extends Record{

  const TABLENAME = 'obm';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Obm');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      $objeto->idAntigo             = $value->id;
      $objeto->nome                 = $value->nome;
      $objeto->novoId               = $value->NOVO_ID;   
      //$objeo->aplicador             = [[]];
  
      $objeto->post("http://localhost:8012/saaf/migrate/obm");
      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Obm');
    $response = $repository->load($criteria);    
    print_r($response);
  }

}