<?php
	class Conf{

	static private $debug = True;
		static private $database = array(
			'hostname' => 'webinfo.iutmontp.univ-montp2.fr',
			'database' => 'moulins',
			'login' => 'moulins',
			'password' => '1114013503T'
		);


	static public function getDebug(){
		return self::$debug;
	}

	static public  function getHostname(){
		return self::$database['hostname'];
	}

	static public  function getDatabase(){
		return self::$database['database'];
	}

	static public  function getLogin(){
		return self::$database['login'];
	}

		static public  function getPassword(){
		return self::$database['password'];
	}

}
?>