<?PHP

class db {
	protected $connection;
	
	function __construct($host,$user,$passwd,$dbname) {
		$this->connection = mysqli_connect($host,$user,$passwd,$dbname);
		mysqli_set_charset($this->connection,"utf8");
	}
	
	function query($query) {
		$data = array();
		$res = mysqli_query($this->connection,$query);

		
		if($res !== TRUE) {
		while($td = mysqli_fetch_assoc($res)) {
			$data[] = $td;
		}
		}
		return $data;
	}
	
	function __destruct () {
		mysqli_close($this->connection);
	}
}

?>
