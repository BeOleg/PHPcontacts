<?php
class Debugger{
	public static function HandleException($e){
		if(Config::$DEBUG_MODE){
			print_r($e->getMessage());
		}
		else{
			//email to admin
		}
	}
}
?>