<?php
require_once "admin.class.php";
require_once "db.class.php";
require_once "function.class.php";
require_once "home.class.php";
require_once "notice.class.php";
require_once "suggestions.class.php";
require_once "lessonsAdmin.class.php";
require_once "lessons.class.php";

class controller{
	function __construct(){
		$this->uri = uri_filter();
		//output($this->uri);
		//echo $this->uri['paths']['2'];
		$allow = array(
					"home", "notice", "admin", "sug", "ladmin", "lessons"
					);
		if(in_array($this->uri['paths']['2'],$allow)){
			$this->controller = new $this->uri['paths']['2'];
		}else{
			info("404");
			exit;
		}
	}

	function run(){
		switch($this->uri['paths']['2']){
			case 'admin':
				$this->controller->log();
				break;
			case 'ladmin':
				$this->controller->log();
				break;
			default:
				switch($this->uri['paths']['3']){
					case 'Null':
							$this->controller->get();
						break;
					case 'post':
							$this->controller->post();
						break;
					case 'put':
							$this->controller->put();
						break;
					case 'del':
							$this->controller->del();
						break;
					default: 
						info("400");
				}
		}
	}
}