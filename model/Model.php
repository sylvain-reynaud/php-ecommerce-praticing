<?php

require_once File::build_path(array("config","Conf.php"));
	
	class Model{

		static public $pdo;

		static public function Init(){
			$hostname = Conf::getHostname();
			$database_name = Conf::getDatabase();
			$login = Conf::getLogin();
			$password = Conf::getPassword();


			try{
				self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
                     array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
   				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				if (Conf::getDebug()) {
    				echo $e->getMessage(); // affiche un message d'erreur
  				} else {
 			   	   echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
  				}
  				die();
			}
		}

		public static function selectAll(){
			$table_name = static::$objet;
			$class_name ="Model".ucfirst($table_name);
			$sql = "SELECT * FROM  $table_name";
			$rep = Model::$pdo->query($sql);
			$rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
			$tab_prod = $rep->fetchAll();
	
			return $tab_prod;
		}

		public static function select($primary_value) {
			$table_name = static::$objet;
			$class_name ="Model".ucfirst($table_name);
			$primary_key = static::$primary;
			$sql = "SELECT * from $table_name WHERE $primary_key = :nom_tag";

			// Préparation de la requête
			$req_prep = Model::$pdo->prepare($sql);
	
			$values = array(
				"nom_tag" => $primary_value,
				//nomdutag => valeur, ...
			);
			// On donne les valeurs et on exécute la requête
			$req_prep->execute($values);
	
			// On récupère les résultats comme précédemment
			$req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
			$tab = $req_prep->fetchAll();
			// Attention, si il n'y a pas de résultats, on renvoie false
			if (empty($tab)){
				return false;
			}
			return $tab[0];
		}

		public static function delete($primary){
			try{
			$table_name = static::$objet;
			$primary_key = static::$primary;
			$class_name ="Model".ucfirst($table_name);
			$sql = "DELETE FROM $table_name WHERE $primary_key =:nom_tag";
			$req_prep = Model::$pdo->prepare($sql);
			$values = array(
				"nom_tag" => $primary,
			);
			$req_prep->execute($values);
		} catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            }
        }
	}

		public  static function update($data){
			$table_name = static::$objet;
			$primary_key = static::$primary;
	
			$set  = "";
			foreach ($data as $key=>$value){
				if ($key != $primary_key){
					$set = $set . "$key=:$key,";
				}
			}
			$set=rtrim($set ,"\t,");

			var_dump($set);
			$sql = "UPDATE $table_name SET $set WHERE $primary_key =:$primary_key";
			var_dump($sql);
			$req_prep = Model::$pdo->prepare($sql);
			$req_prep->execute($data);
	
		}

		public static function save($data){
			try{
			$table_name = static::$objet;
			$primary_key = static::$primary;
			$attribut  = "";
			$val= "";
			foreach ($data as $key=>$value){
				$attribut = $attribut."$key," ;
				$val = $val."'$value'," ;
			}
			$attribut=rtrim($attribut ,"\t,");
			$val = rtrim($val ,"\t,");
			$sql = "INSERT INTO $table_name ($attribut) VALUES ($val)";
			
			$req_prep = Model::$pdo->prepare($sql);
			$req_prep->execute($data);
		} catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            }
        }
        return true;
		}
}
	
	Model::Init();
?>