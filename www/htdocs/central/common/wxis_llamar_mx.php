<?php
    include("../config.php");
	if (isset($wxisUrl) and $wxisUrl!=""){
		//$query.="&path_db=".$db_path;
		$url="http://localhost:9090/cgi-bin/mx.exe?in=/abcd/www/cgi-bin/mx_abcd/boolean.in";
		$url_parts = parse_url($url);
		$host = $url_parts["host"];
		$port = ($url_parts["port"]) ? $url_parts["port"] : 80;
		$path = $url_parts["path"];
		$query = $url_parts["query"];
		$timeout = 10;
		$contentLength = strlen($url_parts["query"]);
        #echo $url;
	// Generate the request header
    	$ReqHeader =
      		"POST $path HTTP/1.0\n".
      		"Host: $host\n".
      		"User-Agent: PostIt\n".
      		"Content-Type: application/x-www-form-urlencoded\n".
      		"Content-Length: $contentLength\n\n".
      		"$query\n";
      		echo $query;
	// Open the connection to the host
			$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
	        $result="";
			fputs( $fp, $ReqHeader );
            $inicio_content="";
			if ($fp) {
				while (!feof($fp)){
                    $a=fgets($fp, 4096);
                    if (trim($a)=="Content-Type: text/html"){
                    	continue;

                    if ($inicio_content=="SI"){
							$result .=$a ;
					}
				}
			}
			#echo "<xmp>" .$result."</xmp>";
			#echo "--".$result."--";
            # die;
            $con=explode("\n",$result);
            $ix=0;
            $contenido=array();
            foreach ($con as $value) {
           		$contenido[]=$value;
            }
  }else{
        $query="";
      	$query.="&path_db=".$db_path;
		putenv('REQUEST_METHOD=GET');
		$q=explode("&",$query);
		$query="";
		foreach ($q as $value){
				if ($ix>0){
					$par=substr($value,$ix+1);
					if ($key=="cipar"){
					if ($par!="")
						$query.="&".$key."=".$par;
			}
        if (file_exists($db_path."par/syspar.par"))
        	$query.="&syspar=$db_path"."par/syspar.par";
		$contenido="";
		putenv('QUERY_STRING='."?xx=".$query);
		echo $query;
	 	exec("/abcd/www/cgi-bin/mx_abcd/mx.exe in=boolean.in" ,$contenido);
	 	foreach ($contenido as $var=>$value) echo "$var=$value<br>";
 }
//$fp=fopen("/abcd/www/scripts","a");
//fwrite($fp,$_SERVER["PHP_SELF"]." ".$IsisScript." ".$query."\n");
//fclose($fp); */
?>