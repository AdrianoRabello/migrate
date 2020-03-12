<?php


  /**
   *
   */
  //require "Expression.php";
  require "Filter.php";
  class Criteria extends Expression{

    private $expressions;
    private $operators;
    private $properties;

    function __construct(){

      $this->expressions = array();
      $this->operators = array();
    }

    public function add(Expression $expression, $operator = self::AND_OPERATOR){

      if (empty($this->expressions)) {

        $operator = NULL;
      }

      $this->expressions[]  = $expression;
      $this->operators[]    = $operator;

    }

    public function dump(){
      // concatena lista de expressoes

      if (is_array($this->expressions)) {
        if (count($this->expressions) > 0) {

          $result = '';
          foreach ($this->expressions  as $i => $expression) {

            $operator = $this->operators[$i];

            //concatena operador com respectiva expressão
            $result .= $operator.$expression->dump().' ';
          }
          $result = trim($result);
          return "({$result})";
        }
      }
    }

    public function setProperty($property, $value){
      if (isset($value)) {
        $thi->properties[$property] = $value;
      }else{
        $this->properties[$property] = NULL;
      }
    }

    public function getProperty($property){
      if (isset($this->properies[$property])) {
        return $this->properties[$property];
      }
    }


  }

  /*$criteria = new Criteria;
  $criteria->add(new Filter('idade','>',60),Expression::OR_OPERATOR);
  $criteria->add(new Filter('sexo','==','m'),Expression::AND_OPERATOR);

  print $criteria->dump();*/

 ?>
