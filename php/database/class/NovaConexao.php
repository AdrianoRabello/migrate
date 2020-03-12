<?php



class NovaConexao{

  
  private $servidor;
  private $usuario;
  private $senha;
	private $nomeBanco;
	private $con;

	/*function __construct($servidor = "localhost",$usuario = "root",$senha="",$nomeBanco = "teste"){
		$this->setServidor($servidor);
		$this->setUsuario($usuario);
		$this->setSenha($senha);
		$this->setNomeBanco($nomeBanco);
		//$this->Conectar();
	}*/
/* functions */


    /*
		Conectar-> realiza conexão com BD
	*/

    function Conectar($servidor= "localhost",$usuario="admin",$senha="cbmes2017",$db = "sisaqua"){
    	$con = new mysqli($servidor,$usuario, $senha,$db);
       	mysqli_set_charset($con,"utf8");
	// Check connection
		if ($con->connect_error) {
		    die("Connection failed: " . $con->connect_error);
		}
        return $con;
	}

	public function Desconectar($con){

		mysqli_close($con) or die(mysqli_error($con));

	}

	/*
		Escape-> Impede o lançamento de SQL nos campos e faz escapar (')
		retorna um array com chave e valor passados
	*/
	public function Escape($dados){
		if(!is_array($dados)){
			$dados = mysql_real_escape_string($dados);
		}else{
			$arr = $dados;
			foreach ($arr as $key => $value) {
				$key   = mysql_real_escape_string($key);
				$value = mysql_real_escape_string($value);
				$dados[$key] = $value;
			}
		}
		return $dados;
	}

	/*
		ExecuteQuery-> Realiza a execução das querys (SQL)
		Retorna o que foi executado para o BD
	*/

	public function ExecuteQuery($query){
		$con = $this->Conectar();
		$result = $con->query($query);
		$this->desconectar($con);

		return $result;
	}

	/*
		DBCreate -> Cria um registro no BD
		Parametros-> (nome da tabela, dados em formato de array);
		retorna a execução da query
	*/

	function DBCreate($table, array $data){
		//$table = "perfilpolitico";
		$data = $this->Escape($data);
		$fields = implode(',', array_keys($data));
		$values = "'".implode("','",$data)."'";
		$query = "INSERT INTO {$table} ({$fields}) VALUES({$values})";
		return  $this->ExecuteQuery($query);
	}

	/*
		DBread-> Reliza leitura dos registros do BD
		Lista de parametros->	DBRead(nome da tabela, condicional para realizar a busca ex:WHERE, nome dos campos do BD)
		retorna os dados em formato de array
	*/
	function DBRead($table, $params = null, $fields = "*"){
    	$params = ($params) ? " {$params}" : null;
		$query  = "SELECT {$fields} FROM {$table}{$params}";
		$result = $this->ExecuteQuery($query);

		$data = array();
		if (!$result->num_rows < 0 ) {
			return false;
		}else{
		 	while ($res = $result->fetch_assoc()) {
		 		$data[] = $res;
		 	}
		}
		return $data;
	}

	/*
		DBupDate-> Atualizar registro no BD
		DBupDate(tabela que vai ser alterada, nome dos campos e valores em formato da array, condicional)
		retorna a query executada
		ATENÇÂO-> se não for passada a condição o comando realizara o comando em todo BD
	*/
	/*function DBUpDate($table, array $data, $where = null){
		foreach ($data as $key => $value) {
			$fields[] = "{$key} = '$value' ";
		}
		$fields = implode(', ', $fields);
		$where = ($where) ? " WHERE {$where}": null;
		$query = "UPDATE {$table} SET {$fields}{$where}";
		return $this->ExecuteQuery($query);
	}*/

	function DBUpDate($table, array $data, $where = null){
		foreach ($data as $key => $value) {
			if(is_numeric ($value)){
				$fields[] = "{$key} = $value ";
			}else{
				$fields[] = "{$key} = '$value' ";
			}

		}
		$fields = implode(', ', $fields);
		$where = ($where) ? " WHERE {$where}": null;
		$query = "UPDATE {$table} SET {$fields}{$where}";
		return $this->ExecuteQuery($query);
	}



	/*
		DBdelete-> deleta um campo no BD
		DBDelete(nome da tabela, condição)
		retorna a execução da query
		ATENÇÂO-> se não for passada a condição o comando realizara o comando em todo BD
	*/

	function DBDelete($table, $where = null){
		$where = ($where) ? " WHERE {$where}": null;
		$query = "DELETE FROM {$table}{$where}";
		return $this->ExecuteQuery($query);
		//var_dump($query);
	}

	/*
		Data()-> Retorna a data atual do sistema operacional do usuario
		Não possui parametros
	*/
	function DataHora(){
		 date_default_timezone_set('America/Sao_Paulo');
            $globalDate = date("d/m/Y");
            $globalHora = date("H:i");
            $date = array(
                  "data" => date("d/m/Y"),
                  "hora" => date("H:i")
                );

            return $date;
	}


	function Data(){
		 date_default_timezone_set('America/Sao_Paulo');
            $globalDate = date("d/m/Y");
            $globalHora = date("H:i");
            $date = array(
                  "data" => date("d/m/Y"),
                  "hora" => date("H:i")
                );

            return $date["data"];
	}

	/*
		Hora()-> Retorna a hora atual do sistema operacional do usuario
		Não possui parametros
	*/

	function Hora(){
		 date_default_timezone_set('America/Sao_Paulo');
            $globalDate = date("d/m/Y");
            $globalHora = date("H:i");
            $date = array(
                  "data" => date("d/m/Y"),
                  "hora" => date("H:i:s")
                );
            return $date["hora"];
	}

	/*
		IniciarSessao-> inicia sessão para usuário autenticado
		Parametros-> IniciarSessao(nome da tabela, $dados do usuario em array,data e hora que logou em formato de array)
		não retorna nada apenas inicia a sessão
	*/

	function IniciarSessao($table,array $dados,array $dateTime){
		SESSION_START();
		$dataLogin = $dateTime['dataLogin'];
		$horaLogin = $dateTime['horaLogin'];
		$res = $this->executeQuery("SELECT * FROM {$table} WHERE usuario = '$dados[usuario]' and senha = '$dados[senha]'");
		while($result = $res->fetch_assoc()) {
			$dados = array (
				"idUsuario"  		=> $result["id"],
				"usuario"    		=> $result["usuario"],
				"unidade" 	 		=> $result["unidade"],
				"graduacao"  		=> $result["graduacao"],
				"nomeGuerra" 		=> $result["nomeGuerra"],
				"numeroFuncional"  	=> $result["numeroFuncional"]
				);


		}

		$_SESSION['idUsuario'] 	 		= $dados['idUsuario'];
		$_SESSION['usuario']	 		= $dados['usuario'];
		$_SESSION['unidade'] 	 		= $dados['unidade'];
		$_SESSION['graduacao']   		= $dados['graduacao'];
		$_SESSION['nomeGuerra']  		= $dados['nomeGuerra'];
		$_SESSION['numeroFuncional']	= $dados['numeroFuncional'];
		$_SESSION['dataLogin']   		= $dateTime['dataLogin'];
		$_SESSION['horaLogin']   		= $dateTime['horaLogin'];

        return $dados;

	}


	function autenticar($table,array $dados,array $dateTime){
		SESSION_START();
		$dataLogin = $dateTime['data'];
		$horaLogin = $dateTime['hora'];
		$res = $this->ExecuteQuery("SELECT * FROM {$table} WHERE senha = '$dados[senha]' and numeroFuncional = '$dados[numeroFuncional]'");
		while($result = $res->fetch_assoc()) {
			$dados = array (
				"idUsuario"  => $result["id"],
				"usuario"    => $result["usuario"],
				"unidade" 	 => $result["unidade"],
				"graduacao"  => $result["graduacao"],
				"nomeGuerra" => $result["nomeGuerra"],
				"funcional"  => $result["numeroFuncional"]
				);


		}

		$_SESSION['idUsuario'] 	 = $dados['idUsuario'];
		$_SESSION['usuario']	 = $dados['usuario'];
		$_SESSION['unidade'] 	 = $dados['unidade'];
		$_SESSION['graduacao']   = $dados['graduacao'];
		$_SESSION['nomeGuerra']  = $dados['nomeGuerra'];
		$_SESSION['funcional']	 = $dados['funcional'];
		$_SESSION['dataLogin']   = $dateTime['data'];
		$_SESSION['horaLogin']   = $dateTime['hora'];
	}



	/* gerar estatistica*/

	function gerarEstatistica($table,array $dados){
		$cont =  array(
				'Resgate' 	 		=>0,
				'APH'		 		=>0,
				'Afogamento' 		=>0,
				'CriancaPerdida'	=>0
			);

		$res = $this->ExecuteQuery("SELECT * FROM {$table} WHERE municipio = '$dados[municipio]'");
		while($result = $res->fetch_assoc()) {
			$dados = array (
				"atendimento"    => $result["atendimento"]
				);

			if($dados['atendimento'] == "APH"){

				$cont['APH'] += 1;

			}else if($dados['atendimento'] == "Resgate"){

				$cont['Resgate'] += 1;

			}else if($dados['atendimento'] == "Afogamento"){

				$cont['Afogamento'] += 1;

			}else if($dados['atendimento'] == "Criança Perdida"){

				$cont['CriancaPerdida'] += 1;
			}




		}

		return json_encode($cont);


	}


	/*
		verifica de tem um cookie se não tiver cria
		retorna o valor do cookie
	*/
	function verificarCookie($cor){
		$background = "";
		if(isset($_COOKIE['background'])){
			$background = $_COOKIE['background'];
		}else{
			setcookie("background",$cor,time() + 20);
			$background = $cor;
		}
		//echo "cor da funcao verificar cookie (".$background." )";
		return $background;
	}

	function inverterData($data){
		$dia = substr($data,0,2);
		$mes = substr($data,3,2);
		$ano = substr($data,6,4);
		$data = $ano."-".$mes."-".$dia;

		return $data;
	}


	/*
		 lerArquivo-> (Nome do arquivo para ser lido que consta no diretorio txt)
		 Retorna-> o conteudo escrito no arquivo txt
	*/
	function lerAquivo($file){
		$filepath = '../txt/$file';
		$fileOpen = fopen('../txt/'.$file,'r');
		$text = fread($fileOpen,filesize($filepath));

		return  $text;
	}


	/*
		 escreverArquivo-> (Nome do arquivo que consta no diretorio txt ou ira cria-lo, texto para ser incluido)
	*/
	function escreverArquivo($file,$texto){
		$fileOpen = fopen('../txt/'.$file,'a');
		fwrite($fileOpen, $texto);
	}



	/*
		Parametros->criptSenha(recebe como parametro uma senha)
		retorna no formato md5 a senha
	*/

	function criptSenha($senha){
		$senha = md5($senha);

		return $senha;
	}

function Query(){

        $con = $this->conectar();
		$sql = "SELECT * FROM ocorencia";
		$result = $con->query($sql) or die(mysqli_error());
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "id: " . $row["id"]. " Atendimento: " . $row["atendimento"]. "<br><br>";
		    }
		} else {
		    echo "0 results";
		}
	}

/* retorna os dados do bando de dados em formato json */

function jsonEncode($sql){
	$result = $this->executeQuery($sql);
	$n 	 = mysqli_num_rows($result);
	if(!$result){
		echo "Há algum erro com a busca ";
	}else if($n < 1){
		echo "Não há registro no Banco de dados";
	}else{
		for ($i=0; $i<$n;$i++) {
		$dados[] = $result->fetch_assoc();
		}
	}

	header('Content-type: application/json');
	echo json_encode($dados,JSON_PRETTY_PRINT);
}





	/* get e set */

	function setServidor($servidor){
		$this->setvidor = $servidor;
	}

	function getServidor(){
		return $this->servidor;
	}


	function setUsuario($usuario){
		$this->usuario = $usuario;
	}

	function getUsuario(){
		return $this->usuario;
	}


	function setSenha($senha){
		$this->senha = $senha;
	}

	function getSenha(){
		return $this->senha;
	}


	function setNomeBanco($nomeBanco){
		$this->nomeBanco = $nomeBanco;
	}

	function getNomeBanco(){
		return $this->nomeBanco;
	}


}


	/*$con = new NovaConexao();
	if (isset($_POST['json'])) {
		$con->jsonEncode("select * from usuario");
	}*/


 ?>
