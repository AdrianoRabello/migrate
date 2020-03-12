<?php

  final class Connection{


    private function __construct(){}

    public static function open($name){
       //verifica se há arquivo de configuração para este banco de dados
       if (file_exists("../php/database/config/{$name}.ini")) {
           $db = parse_ini_file("../php/database/config/{$name}.ini");
       }else{

        throw new Exception("Arquivo '$name' não encontrado da classe conection");
       }

       // lê as informações contida no arquivo
       $user = isset($db['user']) ? $db['user']: NULL;
       $pass = isset($db['pass']) ? $db['pass']: NULL;
       $name = isset($db['name']) ? $db['name']: NULL;
       $host = isset($db['host']) ? $db['host']: NULL;
       $type = isset($db['type']) ? $db['type']: NULL;
       $port = isset($db['port']) ? $db['port']: NULL;

       switch ($type) {
         case 'pgsql':
           $port = $port ? $port : '5432';
            $con = new PDO("pgsql:dbdane={$name}; user={$user}; password={$pass}; host ={$host}; port={$port};");
           break;

         case 'mysql':
           $port = $port ? $port : '3306';
            //$con = new PDO("mysql:host={$host},1433;dbname={$name}", $user, $pass);
            $con = new PDO("mysql:host=$host;dbname=$name;charset=utf8",$user,$pass);
           break;

         default:
         
          echo "Não foi possivel conectar";
           break;
       }

       // define para que o PDO lance exceções
       $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       return $con;
     }
   }


 ?>
