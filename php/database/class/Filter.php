<?php

  class Filter extends Expression{

    private $variable;
    private $operator;
    private $value;
    function __construct($variable, $operator, $value){

      $this->variable = $variable;
      $this->operator = $operator;

      // trnasforma o valor com certas formas de tipo
      $this->value = $this->transform($value);

    }

    private function transform($value){

      if (is_array($value)) {
        foreach ($value as $x) {

          if (is_integer($x)) {
            $foo[] = $x;
          }else if(is_string($x)){

            $foo[] = "'$x'";
          }
        }
        // converte array em string separado por ,
        $result = '('.implode(',',$foo).')';
      }else if(is_string($value)){

        $result = "'$value'";
      }else if(is_null($value)){
        $result = 'NULL';
      }else if(is_bool($value)){

        $result = $value ? 'TRUE': 'FALSE';
      }else{

        $result = $value;
      }

      // retorna o valor
      return $result;
    }

    public function dump(){
      // concatena a expressão
      return "{$this->variable} {$this->operator} {$this->value}";
    }


  }


  /*$filter1 = new Filter('data','=','2017-06-02');

  print $filter1->dump();

  $filter2 = new Filter('genero','=',array('m','f'));

  print $filter2->dump();*/
 ?>
