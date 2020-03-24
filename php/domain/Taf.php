
<?php

class Taf extends Record{

  const TABLENAME = 'taf';
  function __construct(){

    //echo "teste";

  }



  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Taf');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      $objeto->nome = $value->descricao;
     $objeto->post("http://localhost:8012/saaf/migrate/taf");
      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Taf');
    $response = $repository->load($criteria);
    
    print_r($response);
  }



}