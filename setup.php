<?php
class db{
	private $host;
	private $user;
	private $pass;
	private $db;

	private $link; 
	private $st; 
	private $cierra; 
	private $liberar;
	private $array;
	private $numRows;
	private $affectedRows;

	static $_instance; 
	

	public function __construct(array $cfg){
		foreach($cfg as $key=>$val){
            $this->{$key}=$val;
        }
		
	}
	
	/*Evitamos el clonaje del objeto. Patrón Singleton*/
	private function __clone(){}
	
	
	/*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
	public static function getInstance(){  
		if (!(self::$_instance instanceof self)){  
			self::$_instance=new self();  
		}  
		return self::$_instance;  
	}

	/*Realiza la conexión a la base de datos.*/
	public function connect($db=null){
		if($db != null)
			$this->db = trim(strtolower($db));

		$this->link = mysqli_connect($this->host,$this->user,$this->pass);
		if(!$this->link){
			echo "No existe conexión con base de datos<br>";
			return false;
			die;
		}else{
			$sdb=mysqli_select_db($this->link,$this->db);
			if(!$sdb){
				echo "No se encuentra la base de datos<br>";
				return false;
			}else{
				return true;
			}
		}
	}

	/*Método para ejecutar una sentencia sql*/
	public function executeQuery($sql){
		$this->st = mysqli_query($this->link,$sql);
		return $this->st;
	}

	/*Método para Cerrar la DB sql*/
	public function close(){
		$this->cierra= mysqli_close($this->link);
		return $this->cierra;
	}

	/*Método para Liberar la memoria o a willy la ballena*/
	public function free(){
		$this->liberar = mysqli_free_result($this->st);
		return $this->liberar;
	}

	/*Método para obtener una fila de resultados de la sentencia sql*/ 
	public function getDataArray($stmt,$fila){
		if ($fila==0){
			$this->array=mysqli_fetch_array($stmt);
		}else{
			mysqli_data_seek($stmt,$fila);
			$this->array=mysqli_fetch_array($stmt);
		}
		return $this->array; 
	}

	//Devuelve el número de filas de un result set
	public function getNumRows($rs){
		$this->numRows = mysqli_num_rows($rs);
		return  $this->numRows;
	}

	//Devuelve el último id del insert introducido 
	public function lastId(){ 
		return mysqli_insert_id($this->link); 
	} 
	//Devuelve el error ocurrido en la base de datos
	public function error(){
		return mysqli_error($this->link);
	}

	//Devuelve el nombre de la base de datos actual
	public function getDB(){
		return $this->db;   
	}
	//Setea el nombre de la base de datos actual
	public function setDB($database){
		$this->db	=	$database;
	}

	//Devuelve el nombre de usuario
	public function getUser(){
		return $this->user;
	}
	//Setea el nombre de usuario
	public function setUser($user){
		$this->user	=	$user;
	}

	//Devuelve la password
	public function getPass(){
		return $this->pass;
	}
	//Setea la password
	public function setPass($password){
		$this->pass	=	$password;
	}
	//Devuelve la host
	public function getHost(){
		return $this->host;
	}
	//Setea la host
	public function setHost($host){
		$this->host	=	$host;
	}

	public function getAffectedRows(){
		$this->affectedRows = mysqli_affected_rows($this->link);
		return $this->affectedRows;
	}

}
?>