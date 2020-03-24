
<?php

class TipoTaf extends Record{

  const TABLENAME = 'tipotaf';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('TipoTaf');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      //$objeto->descricao = $value->idPosto;
      $objeto->idAntigo     = $value->id;
      $objeto->ativo        = $value->ativo;
      $objeto->descricao    = $value->descricao;
 

     //print_r($objeto);

     $objeto->post("http://localhost:8012/saaf/migrate/tipotaf");
      
    }

   
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('TipoTaf');
    $response = $repository->load($criteria);
    
    print_r($response);
  }

}