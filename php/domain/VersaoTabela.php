
<?php

class VersaoTabela extends Record{

  const TABLENAME = 'versaotabela';
  function __construct(){

    //echo "teste";

  }


  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('VersaoTabela');
    $results = $repository->load($criteria);

    foreach ($results as $key => $value) {    
      $objeto = new Objeto();
      $objeto->idAntigo             = $value->id;
      $objeto->ativa                = $value->ativa;
      $objeto->versao               = $value->versao;   
      $objeto->listaNotas           = [];  
      $objeto->listaTafs            = [];  
      //$objeo->aplicador             = [[]];
  
      $objeto->post("http://localhost:8012/saaf/migrate/versaotabela");
      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('VersaoTabela');
    $response = $repository->load($criteria);    
    print_r($response);
  }

}