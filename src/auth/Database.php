<?php 

class Database {
	private static $db_host = "localhost";
	private static $db_name = "ask_me_db";
	private static $db_user = "root";
	private static $db_password = "root";

	public static function connectSqli() {
		$dbh = mysqli_connect(self::$db_host, self::$db_user, self::$db_password, self::$db_name);
		
		if(!$dbh)
		{
			die();
		}
		else
		{
			return $dbh;
		}
	}
}