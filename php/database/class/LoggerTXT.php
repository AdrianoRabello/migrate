<?php

  /**
   *
   */
  class LoggerTXT extends Logger{

      public function write($message){
        date_default_timezone_set('America/Sao_Paulo');
        $time = date('T-m-d H:i:s');

        $text  = "$time :: $message\n";


        // adiciona ao final do arquivo
        $handler = fopen($this->fileName,'a');
        fwrite($handler,$text);
        fclose($handler);
      }
  }


 ?>
