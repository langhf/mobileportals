<?php
require_once "config.php";
require_once "function.class.php";
class db{
	//public $pdo;
	//init database
	function __construct(){
		global $dsn;
		global $dbusr;
		global $dbpsw;
		$this->pdo = new PDO($dsn,$dbusr,$dbpsw) or info("400");
		$this->pdo->query("set names utf8;");
		$this->pdo->query("set time_zone = '+8:00';");
		return $this->pdo;
	}
	//column->字段 tabname->表名 sid->开始的id eid->结束的id
	function get($column,$tabname){
		$sql = "select $column from $tabname";
		//echo $sql;
		$brig = $this->pdo->query($sql);
		$re = array(
				"stat"=>"SUCCESS",
				"statcode"=>"200"
					);
		while($result = $brig->fetchall(PDO::FETCH_ASSOC)){
			$re['data'] = $result;
		}
		 return $re;
	}
	//$others = array( advisor=> 
	//					tag=>
	//					read=>
	//						 )
	function post($title,$content,$tabname,$others){
		switch($tabname){
			case 'home':
					$sql = "INSERT INTO $tabname (`title`, `content`) VALUES ('$title','$content')";
				break;
			case 'suggestions':
					$sql = "INSERT INTO $tabname (`content`, `advisor`) VALUES ('$content','$others')";
				break;
			case 'notice':
					$sql = "INSERT INTO $tabname (`title`, `content`, `tag`) VALUES ('$title', '$content','$others')";
				break; 

			case 'lessons':
					$sql = "INSERT INTO $tabname (`title`, `content`) VALUES ('$title','$content')";
				break;
		}
		//echo $sql;
		$re = $this->pdo->query($sql);
		if($re->rowcount()){
			info("201");
		}else{
			info("400");
		}
	}

	function put($id,$title,$content,$tabname,$others){
		if(is_numeric($id)){
			switch($tabname){
				case 'home':
					$sql = "UPDATE `home` SET `title`='$title',`content`='$content' WHERE `id`='$id'";
					break;

				case 'notice':
					$uri = uri_filter();
					switch($uri['query']){
						case '1':
							$sql = "UPDATE `notice` SET `title`='$title',`content`='$content',`tag`='{$others["0"]}' ,`read`= '{$others["1"]}' WHERE `id`='$id'";
							break;
						case '2':
							$sql = "UPDATE `notice` SET `read`= '{$others["1"]}' WHERE `id`='$id'";
							break;
					}
					
				case 'suggestions':
					$sql = "UPDATE `suggestions` SET `title`='$title',`content`='$content' WHERE `id`='$id'";
					break;	

				case 'lessons':
					$sql = "UPDATE `lessons` SET `title`='$title',`content`='$content' WHERE `id`='$id'";
					break;		
			}

			$re = $this->pdo->query($sql);
			if($re->rowcount()){
				info("200");
			}else
				info("400");
		}else
			info("400");
	}

	function del($tabname,$id){
		if(is_numeric($id)){
			$sql = "DELETE FROM $tabname WHERE `id`='$id'";
			$re = $this->pdo->query($sql);
			if($re->rowcount()){
				info("204");
			}else
				info("400");
		}
	}
}