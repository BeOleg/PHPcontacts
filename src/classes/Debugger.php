<?php
class Debugger{
	public static function HandleException($e, $sql = ''){
		if(Config::$DEBUG_MODE){
			print_r($e->getMessage());
			echo "<br><br>{$sql}<br><br>";
		}
		else{
			//email to admin
		}
	}
}
?>