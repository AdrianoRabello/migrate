<?php 

	abstract class Record{

		protected $data;

		public function __construct($id = NULL){
			if ($id) {
				$object = $this->load($id);

				if ($object) {
					$this->fromArray($object->toArray());
				}
			}

		}

		public function __clone(){
			unset($this->data['id']);
		}

		public function __set($prop,$value){
			if (method_exists($this,'set'.lcfirst($prop))) {
				call_user_func(array($this,'set'.lcfirst($prop)),$value);
			}else{
				if ($value == NULL ) {
					// se o valor estiver nulo deleta a propriedade
					unset($this->data[$prop]);
				}else{
					// atribui o valor a propriedade 
					$this->data[$prop] = $value;
				}
			}
		}

		public function __get($prop){
			if (method_exists($this, 'get'.lcfirst($prop))) {
				// executa o metodo get da propriedade 
				return call_user_func(array($this,'get'.lcfirst($prop)),$value);
			}else{
				if (isset($this->data[$prop])) {
					return $this->data[$prop];
				}
			}
		}

		public function __isset($prop){
			return isset($this->data[$prop]);
		}

		// responsalvel por retornar o nome da tabela onde o Ative Recorde será persistido 
		private function getEntity(){
			$class = get_class($this);//     obtem o nome da classe
      return constant("{$class}::TABLENAME"); // retorna a constante da classe TABLENAME
      
      //return strtolower($class);
		}
		
		public function fromArray($data){
			$this->data = $data;
		}

		public function toArray(){
			return $this->data;
		}


		// metodo par agravar no BD ou realizar update 
		public function store(){
			//$prepared = array();
			$prepared = $this->prepare($this->data);

			//var_dump($this->data);
			//print_r($prepared);

			//verifica se tem um id na bse de dados
			if (empty($this->data['id']) or (!$this->load($this->id))) {
				// incerementa o id 
				/*if (empty($this->data['id'])) {
					$this->id = $this->getLast() + 1;					
					$prepared['id'] = $this->id;																	
				}*/
				//print_r($prepared);

				// cria a instrução de insert 
				$sql = "INSERT INTO {$this->getEntity()} ".
				'('.implode(', ', array_keys($prepared)).')'.
				'values'.
				"(".implode(', ', array_values($prepared))." )";

				print $sql;


			}else{
				// monta a instrução de update 
				$sql = "UPDATE {$this->getEntity()}";
				if ($prepared) {
					foreach ($prepared as $column => $value) {
						if ($column !== 'id') {
							$set[] = "{$column} = {$value}";
						}						
					}
				}
				$sql .= ' SET '.implode(',', $set);
				$sql .= ' WHERE id='.(int) $this->data['id'];
			}

			// obtem a transação ativa 
			if ($con = Transaction::get()) {
				Transaction::log($sql);
				$result = $con->exec($sql);
				return $result;
			}else{
				throw new Exception(' Não há transação ativa');
			}

			print $sql;
			
		}

		
		// ira selecionar o objeto no BD 
		public function load($field,$value){
			//print $id;
			//monta a instrução select 
			$sql = "SELECT * FROM {$this->getEntity()}";
			$sql .= " WHERE {$field} = ".$value;
			print $sql;
			//obtem a transação ativa 
			if ($con = Transaction::get()) {
				// cria a mensagem de log 
				Transaction::log($sql);
				$result = $con->query($sql);
				// se retornou algum dado 				
				if ($result->rowCount()) {
					$object = $result->fetchObject(get_class($this));	
					//$object = $result->fetchObject();	
					return $object;				
				}else{

					throw new Exception("Não há dados na tabela {$this->getEntity()} com o valor $value");

					//echo "teste";
				}				
							
			}else{
				throw new Exception("Não há transação ativa");
			}
		}
		// ira selecionar o objeto no BD 
		public function loadById($field){
			//print $id;
			//monta a instrução select 
			$sql = "SELECT * FROM {$this->getEntity()}";
			$sql .= " WHERE {$field} = ".$field;
			//print $sql;
			//obtem a transação ativa 
			if ($con = Transaction::get()) {
				// cria a mensagem de log 
				Transaction::log($sql);
				$result = $con->query($sql);
				// se retornou algum dado 				
				if ($result->rowCount()) {
					$object = $result->fetchObject(get_class($this));	
					//$object = $result->fetchObject();	
					return $object;				
				}else{

					throw new Exception("Não há dados na tabela {$this->getEntity()} com o valor $value");

					echo "teste";
				}				
							
			}else{
				throw new Exception("Não há transação ativa");
			}
		}


		public function delete($id = NULL){
			// o id é parametro ou propriedade 
			$id = $id ? $id : $this->id;

			//monta a strng para deletar 
			$sql = "DELETE FROM {$this->getEntity()}";
			$sql .= " WHERE id = ".(int)$this->data['id'];

			// obtem a transação ativa 
			if ($con  = Transaction::get()) {
				// executa o sql 
				Transaction::log($sql);
				$result = $con->exec($sql);
				return $result;
			}else{
				throw new Exception("Não há transação ativa");
				
			}
		}


		// esse metodo é apenas um atalho para o meotod load. Podemos acessa-lo diretamente sem instaciar a classe 
		public static function find($id){
			$className = get_called_class();
			//print $className;
			$ar = new $className;
			return $ar->load($id);
		}

		public function findById($url){  
			$ch = curl_init();    
			curl_setopt($ch,CURLOPT_URL, $url);   
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			  'Content-Type: application/json',      
			  ));      
		  
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);   
			$result = curl_exec($ch);

			//echo $result;
			return $result;
			//echo $result;
		  }

		// serve para retornar o ultimo id do BD
		private function getLast(){
			if ($con = Transaction::get()) {
				//$sql = "SELECT max(id) FROM {$this->getEntity()}";

				// cria o log da instrução sql
				Transaction::log($sql);
				$result = $con->query($sql);

				// retorna os dados do BD
				$row = $result->fetch();
				return $row[0];
			}else{
				throw new Exception("Não há transação ativa");
				
			}
		}

		//  recebe um valor e o formata de acordo com o tipo de dado 

		public function escape($value){
			if (is_string($value) and (!empty($value))) {
				$value = addslashes($value);
				return "'$value'";

			}else if (is_bool($value)) {
				return $value ? 'TRUE' : 'FALSE';

			}else if ($value !== '') {
				return $value;

			}else{
				return "NULL";
				
			}
		}

		// reponsavel por preparar os dados antes de inserir no BD 
		public function prepare($data){
			$prepared = array();
			foreach ($data as $key => $value) {
				if (is_scalar($value)) {
					$prepared[$key] = $this->escape($value);
				}
			}
			return $prepared;
		}	

		public static function showError($e){
			echo json_encode(array(
			"message"=>$e->getMessage(),
			"line"=>$e->getLine(),
			"file"=>$e->getFile(),
			"code"=>$e->getCode()
			));
    }
    
   

    public function post($url){

		//$token = " Breare eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJhZHJpYW5vLnJhYmVsbG8iLCJ1c3VhcmlvIjp7ImlkIjoiMTYiLCJub21lIjoiQURSSUFOTyBST0RSSUdVRVMgUkFCRUxMTyIsInBvc3RvR3JhZHVhY2FvIjoiQ0IgQk0iLCJvZmljaWFsIjoiTiIsIm5vbWVHdWVycmEiOiJSQUJFTExPIiwibnVtZXJvRnVuY2lvbmFsIjoiMzM2ODg0MCIsImNwZiI6IjEyMDU1NjczNzI2IiwiZW1haWwiOiJhZHJpYW5vci5yYWJlbGxvQGhvdG1haWwuY29tIiwibG9jYWlzIjp7ImxvY2FsUW8iOnsiaWQiOjEwMSwic2lnbGEiOiJEQUwiLCJub21lIjoiRElSRVRPUklBIERFIEFQT0lPIExPR8ONU1RJQ08ifSwibG9jYWxRZGkiOnsiaWQiOjEzMSwic2lnbGEiOiJHVEkiLCJub21lIjoiR0VSw4pOQ0lBIERFIFRFQ05PTE9HSUEgREEgSU5GT1JNQcOHw4NPIGRhIERBTCJ9LCJsb2NhbEFkaWRvIjoiIn19LCJyb2xlc0ludHJhbmV0IjpbIkdHX2ludHJhbmV0X2FkbWluIiwiR0dfaW50cmFuZXRfY2JtZXMiLCJHR19pbnRyYW5ldF9jcmlhck5vdGljaWEiLCJHR19pbnRyYW5ldF9ibTYiLCJHR19pbnRyYW5ldF9kYWwuZ3RpIiwiR0dfaW50cmFuZXRfZGFsIiwiR0dfaW50cmFuZXRfZW1nIiwiR0dfaW50cmFuZXRfY2JtZXMiLCJHR19pbnRyYW5ldF9jcmlhckFycXVpdm9zIl0sInJvbGVzIjpbIlNBRk9fR2VyYWxSSCIsIlNJR09fVXN1YXJpbyIsIk1BTlVBRF9BZG1pbmlzdHJhZG9yIiwiQWRtaW5pc3RyYWRvciIsIlNBQUZfQWRtaW5pc3RyYWRvciIsIlNJR09fQWRtaW5pc3RyYWRvciIsIlNBRk9fQ2FkYXN0cm9PQk0iLCJBcmVhVGVjbmljYSIsIlNBRk9fQ2FkYXN0cm9SSCIsIlNBRk9fQWRtaW5pc3RyYWRvciIsIlNBRk9fVXN1YXJpbyIsIlNBRk9fR2VyZW5jaWFSSCIsIlNBRk9fQ2hlZmlhT0JNIl0sImV4cCI6MTU4NDA1MDg0MX0.8Ctr5Oxo-SvfmwnK1CKmenbsZPQ2bK2zTPlGokIalnQH4-E6JRExTweyfdc3AXzDhgELyjE8AmutzoEwTPx8-A";
      
      $ch = curl_init();
      
      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($this->data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json'
	));
      
      //So that curl_exec returns the contents of the cURL; rather than echoing it
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
      
      //execute post
      $result = curl_exec($ch);

	  echo $result;
	  echo "<br>";
    }


    public function patch($url){

      $ch = curl_init($url."/{$this->id}");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',  
		   
        ));  
      curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($this->data));
      $response = curl_exec($ch);      
      echo $response;
    }


    public function get($url){  
      $ch = curl_init();    
      curl_setopt($ch,CURLOPT_URL, $url."/{$this->id}");   
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',      
        ));      
    
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);   
      $result = curl_exec($ch);
      echo $result;
    }



	}
 ?>