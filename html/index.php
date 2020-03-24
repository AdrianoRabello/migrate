


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
    </div>

    <div class="row justify-content-center">

    <div class="col-md-8 "> 

    <div class="card">
      <div class="card-header">
      <h6 class="text-center">Valores</h6>
      </div>
      <div class="card-body">
      <dvi class="row">
        <div class="col-md-12">
        <pre>
     
    
          <?php 
            
            include "../php/database/class/autoload.php";
            include '../php/domain/Objeto.php';
           
            include '../php/domain/PostGrad.php';
            include '../php/domain/Obm.php';
            include '../php/domain/Pessoa.php';  
            include '../php/domain/Modalidade.php';  
            include '../php/domain/TipoTaf.php';  
            include '../php/domain/Taf.php';  
            include '../php/domain/VersaoTabela.php';  
                
          
          
            /*PostGrad::migrate();
            Obm::migrate();    
            Pessoa::migrate(); 
            Modalidade::migrate(); 
            TipoTAf::migrate();             
            VersaoTabela::migrate();
            Taf::migrate(); */
              
         
            //PostGrad::show();
            //Pessoa::show();
           // PostGrad::show();  
           //Obm::show();
           //Modalidade::show();
            //TipoTAf::show();           
            //VersaoTabela::show();
            Taf::show();
          ?>
        </pre>
        </div>
      </dvi>
      


      </div>
    </div>  
   

    
    </div>


    </div>
    </div>
  </div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>