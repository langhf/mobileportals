<?php
require_once "config.php";
require_once "function.class.php";
class ladmin{

	function log(){

		session_start();
		@$usr = $_POST["usr"];
		@$psw = $_POST["psw"];
		global $lessonsUsrname;
		global $lessonsPsw;

		if(empty($_SESSION['lauthority'])){
			if($usr == $lessonsUsrname && $psw == $lessonsPsw){
				$_SESSION['lauthority']= "yes";
				$re = array(
						"stat"=>"login success",
						"statcode"=>"200"
						);
				output($re);
			}else
				info("400");	
		}else{
			$_SESSION['lauthority']=="yes"?$_SESSION['lauthority']='':info("400");
			$re = array(
					"stat"=>"logout success",
					"statcode"=>"200"
					);
			output($re);
		}	
	}
}
