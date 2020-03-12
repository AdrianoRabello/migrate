
<?php

class Unidade extends Record{

  const TABLENAME = 'unidade';
  function __construct(){

    //echo "teste";

  }

  function getIdUndiade(){
    return $this->data->idUnidade;
  }

}