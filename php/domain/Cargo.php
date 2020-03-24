
<?php

class Cargo extends Record{

  const TABLENAME = 'cargo';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Cargo');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      $objeto->descricao = $value->descricao;
      //$objeto->usuarios = [];

      //print_r($objeto);

     $objeto->post("http://localhost:8012/cargos");
      
    }

    $objeto = new Objeto();
    $objeto->descricao = "teste";
    $objeto->post("http://localhost:8012/cargos");
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Cargo');
    $response = $repository->load($criteria);
    
    print_r($response);
  }

}