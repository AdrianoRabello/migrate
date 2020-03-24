
<?php

class Pessoa extends Record{

  const TABLENAME = 'pessoa';
  function __construct(){

    //echo "teste";

  }

  public static function migrate(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Pessoa');
    $results = $repository->load($criteria);

    $cont = 0;
   
    foreach ($results as $key => $value) {    

      $cont ++;

      //if($cont == 1){


        $objeto = new Objeto();
        $objeto->idAntigo           = $value->id;
        $objeto->nlogin                = $value->nlogin;
        $objeto->sexo                  = $value->sexo;
        $objeto->nome                  = $value->nome;
        $objeto->ativa                 = true; //$value->ativa;
        $objeto->auxsef                = true;//$value->auxsef; // $value->auxsef?$value->auxsef:false;
        $objeto->cpf                   = $value->cpf;
        $objeto->dtnascimento          = $value->dtnascimento;  
        $obm                           =  json_decode($objeto->findById("http://localhost:8012/saaf/migrate/obm/{$value->obm_id}"));
        $objeto->obm                  = ["id"=> $obm->id]  ;    
        $postgrad                     = json_decode($objeto->findById("http://localhost:8012/saaf/migrate/postgrad/{$value->postgrad_id}"));
        $objeto->postgrad              =["id" => $postgrad->id];
                      
        
        //print_r($objeto);
        $objeto->post("http://localhost:8012/saaf/migrate/pessoa");
  
          
        
        //print_r($objeto->postgrad);
      //}

    
      
    }
  }

  public static function show(){

    $con = Transaction::open('db');   
    $criteria = new Criteria( new Filter('1','=','1'));
    $repository = new Repository('Pessoa');
    $response = $repository->load($criteria);
    
    print_r($response);
  }



}