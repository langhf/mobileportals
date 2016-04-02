<?php

function output($foo){
	echo json_encode($foo);
}

function info($foo){
	$info = array(
				"200"=>array(
						"stat"=>"SUCCESS",//客户端向服务器请求数据，服务器成功找到它们
						
						"statcode"=>"200"
						),
				"201"=>array(
						"stat"=>"CREATED",//客户端向服务器提供数据，服务器根据要求创建了一个资源
						"statcode"=>"201"
						),
				"204"=>array(
						"stat"=>"NO CONTENT",//客户端要求服务器删除一个资源，服务器删除成功
						"statcode"=>"204"
						),
				"400"=>array(
						"stat"=>"INVALID REQUEST",//客户端向服务器提供了不正确的数据，服务器什么也没做
						"statcode"=>"400"
						),
				"404"=>array(
						"stat"=>"NOT FOUND",//客户端引用了一个不存在的资源或集合，服务器什么也没做
						"statcode"=>"404"
						),
				"500"=>array(
						"stat"=>"INTERNAL SERVER ERROR",//服务器发生内部错误，客户端无法得知结果，即便请求已经处理成功
						"statcode"=>"500"
						),
			);
	switch($foo){
		case '200':
				output($info['200']);
			break;
		case '201':
				output($info['201']);
			break;
		case '204':
				output($info['204']);
			break;
		case '400':
				output($info['400']);
			break;
		case '404':
				output($info['404']);
			break;
		case '500':
				output($info['500']);
			break;
		default: output($info['404']);
	}
}

function uri_filter(){
	$uri = $_SERVER['REQUEST_URI'];
	$uri = substr($uri,0,80);//cut down the URL
	if(preg_match('/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$uri)){
		$uri = parse_url($uri);
		//output($uri);
		$uri_paths = explode("/",$uri['path']);

		if(@$uri['query']==""){
			$uri_query="Null";
		}else{
			$uri_query = $uri['query'];
			if(preg_match("/\&+/i",$uri_query)){
				$uri_query = explode("&",$uri_query);
				for($i="0";$i<count($uri_query);$i++){
					$temp = explode("=",$uri_query[$i]);
					@$subtemp[$temp['0']] = $temp['1'];
				}
				$uri['query'] = $subtemp;//不能直接赋值给未定义的二维关联数组
			}else{
				$temp = explode("=",$uri_query);
				foreach ($temp as $value) {
					$subtemp[] = $value;
				}
				$uri['query'] = array($subtemp['0']=>$subtemp['1']);
			}
		}

		//echo $uri['query'];
		$uri = array(
					"paths"=>$uri_paths,
					"query"=>@$uri['query']
					);

		@$uri['paths']['3']==""?$uri['paths']['3']="Null":'';
		return $uri;
	}
}	

/*class usr{

	function __construct(){
		$this->db = new db;
	}

	//获取在微信上的个人信息  包括个人申请中心岗位等
	function getSelf(){
		$opts = array(
  				'http'=>array(
    				'method'=>"GET",
    			//添加多条header的时候需要用\r\n，否则会出错
    			'header'=>"apikey:4318e5858b5160ad2a3a3663858fd23b\r\n".
    		 	 "Content-Type:application/x-www-form-urlencoded"
 				 )
				);
		$context = stream_context_create($opts);
		$cityname = "合肥";
		$url = "http://apis.baidu.com/apistore/weatherservice/citylist?cityname=$cityname";
		if($re = file_get_contents($url,false,$context)){
			echo $re;
		}else
			info("400");
	}
	//发送建议
	function postSug(){
		@$content = strip_tags($_POST['content']);
		$advisor = empty($_POST['advisor'])?$_POST['advisor']="":'';
		//echo $content;
		$tabname = "suggestions";
		if(!empty($content)){
			$this->db->post("",$content,$tabname,$advisor);
		}else
			info("400");
	}
}*/

//  /api/ 
//  /api/h?hid= home
//  /api/h/post
//  /api/h h_get 获取全部的home信息
//  
//  /api/v?vid= view 
//  /api/n?nid= notification
//  /api/m?mid= me
//  
//  /api/a/login 请求登录
//  /api/a/logout 请求注销
//  /api/a/put请求更新home的数据
//  /api/a/post a_post 增加home的信息
//  /api/a/del  a_del  删除home的一条信息
//  防sql注入  substr()  mysql_real_escape_string() strtolower() preg_replace() is_numeric() ereg()
//  ob_clean() 清除输出缓冲区
//  修改.htaccess文件，屏蔽无关文件
//  修改mobileprotals.local的api权限，只限index.html使用