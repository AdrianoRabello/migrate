
<?php

class Unidade extends Record{

  const TABLENAME = 'unidade';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Unidade');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      $objeto->nome = $value->nomeUnidade;
     $objeto->post("http://localhost:8012/unidades");
      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Unidade');
    $response = $repository->load($criteria);
    
    print_r($response);
  }

}