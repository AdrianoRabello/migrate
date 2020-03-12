


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid ">

    <div class="row">
    <div class="col-md-12">
      <h1>Migrate</h1>
    </div>

    <div class="row">

    <div class="col-md-12 text-left ml-5">

    <code>
    
    <?php 
      
      include '../php/database/class/autoload.php';
      include '../php/domain/Unidade.php';
      include '../php/domain/Author.php';
      include '../php/domain/Objeto.php';
     

      
    
      $con = Transaction::open('sisaqua');      
      $object = new Unidade();


      //var_dump($object->loadById(1));

      $criteria = new Criteria( new Filter('1','=','1'));
      $repository = new Repository('Unidade');

      $unidades = $repository->load($criteria);

      foreach($unidades as $value => $key){
        $unidade = new Unidade();
        $unidade->title = $key->nomeUnidade;
        //$unidade->request("http://localhost:8012/books");

        $author = new Author();
        $author->nome = "Adriano";
      //$author->post("http://portal.cb.es.gov.br/email-service/email");
       
      }


      
      foreach($unidades as $key => $value){


        //print_r($value);
        //print_r($key);
        //echo $value->get.lcfirst($key);
        //echo($key->get.lcfirst($value));
      //$author->post("http://portal.cb.es.gov.br/email-service/email");
       
      }

      $obj = new Objeto();
      $obj->id = 3;
      $obj->get("http://localhost:8012/author");

      

      //var_dump($unidades);

      //$unidade->request();

      //Repository::showTables();

    ?>

    </code>
    </div>


    </div>
    </div>
  </div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>