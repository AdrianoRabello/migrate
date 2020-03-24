
<?php

class PostGrad extends Record{

  const TABLENAME = 'postgrad';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('PostGrad');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {  
      
      //print_r($value);
      $objeto = new Objeto();
      $objeto->idAntigo         = $value->id;
      $objeto->numeroordenacao   = $value->numeroordenacao;
      $objeto->abreviacao    = $value->abreviacao;
      $objeto->descricao        = $value->descricao;
     
 


      $objeto->post("http://localhost:8012/saaf/migrate/postgrad");

   
      


      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('PostGrad');
    $response = $repository->load($criteria);
    
    print_r($response);
  }

}