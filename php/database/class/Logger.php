<?php

  abstract class Logger{

    protected $fileName;

    function __construct($fileName){
      $this->fileName = $fileName;
      // limpa o conteúdo do  arquivo
      //file_put_contents($fileName,'');
    }

    abstract function write($message);

  }






 ?>
