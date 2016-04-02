<?php
require_once "config.php";
require_once "function.class.php";
class admin{

	function log(){

		session_start();
		@$usr = $_POST["usr"];
		@$psw = $_POST["psw"];
		global $adminUsrname;
		global $adminPsw;

		if(empty($_SESSION['authority'])){
			if($usr == $adminUsrname && $psw == $adminPsw){
				$_SESSION['authority']= "yes";
				$re = array(
						"stat"=>"login success",
						"statcode"=>"200"
						);
				output($re);
			}else
				info("400");	
		}else{
			$_SESSION['authority']=="yes"?$_SESSION['authority']='':info("400");
			$re = array(
					"stat"=>"logout success",
					"statcode"=>"200"
					);
			output($re);
		}	
	}
}
