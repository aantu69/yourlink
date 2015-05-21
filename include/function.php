<?php
function curl_get_call($url)
{
	$headers=array(
		//'Authorization : f5bc6668bb83ebbad013fad2e8404ba7',
		//'Authorization :'.$api_key,
		'Accept : application/json',
		'Content-Type : application/json',
	);

	$handle=curl_init();
	curl_setopt($handle, CURLOPT_URL,$url);
	//curl_setopt($handle, CURLOPT_HEADER, true);
	curl_setopt($handle, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER,true);
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	//curl_close($handle);
	return $response;
	//curl_close($handle);
}
function curl_get_call_with_auth($url,$api_key)
{
	$headers=array(
		//'Authorization : f5bc6668bb83ebbad013fad2e8404ba7',
		'Authorization :'.$api_key,
		'Accept : application/json',
		'Content-Type : application/json',
	);

	$handle=curl_init();
	curl_setopt($handle, CURLOPT_URL,$url);
	//curl_setopt($handle, CURLOPT_HEADER, true);
	curl_setopt($handle, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER,true);
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	curl_close($handle);
	return $response;
	//curl_close($handle);
}

function curl_post_call($url,$data)
{
	$headers=array(
		//'Authorization :'.$api_key,
		'Accept:application/json',
		'Content-Type:application/json'
		//'Content-Type:application/x-www-form-urlencode'
	);
	//$mfields = '';
	//foreach($data as $key => $val) {
	//	$mfields .= $key . '=' . $val . '&';
	//}
    //rtrim($mfields, '&');
	$handle=curl_init();
	curl_setopt($handle,CURLOPT_URL,$url);
	curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($handle,CURLOPT_VERIFYHOST,false);
	//curl_setopt($handle,CURLOPT_VERIFYPEER,false);
	curl_setopt($handle,CURLOPT_POST,true);
	curl_setopt($handle,CURLOPT_POSTFIELDS,$data);
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	
	return $response;
}

function curl_post_call_with_auth($url,$data,$api_key)
{
	$headers=array(
		'Authorization :'.$api_key,
		'Accept:application/json',
		'Content-Type:application/json'
	);
	$handle=curl_init();
	curl_setopt($handle,CURLOPT_URL,$url);
	curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($handle,CURLOPT_VERIFYHOST,false);
	//curl_setopt($handle,CURLOPT_VERIFYPEER,false);
	curl_setopt($handle,CURLOPT_POST,true);
	curl_setopt($handle,CURLOPT_POSTFIELDS,$data);
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	
	return $response;
}

function curl_put_call($url,$data)
{
	$headers=array(
		//'Authorization :'.$api_key,
		'Accept:application/json',
		'Content-Type:application/json'
	);
	$handle=curl_init();
	curl_setopt($handle,CURLOPT_URL,$url);
	curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($handle,CURLOPT_POST,true);
	//curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($handle,CURLOPT_POSTFIELDS,$data);
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	
	return $response;
}

function curl_put_call_with_auth($url,$data,$api_key)
{
	$headers=array(
		'Authorization :'.$api_key,
		'Accept:application/json',
		'Content-Type:application/json'
	);
	$handle=curl_init();
	curl_setopt($handle,CURLOPT_URL,$url);
	curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($handle,CURLOPT_POST,true);
	//curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($handle,CURLOPT_POSTFIELDS,$data);
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	
	return $response;
}

function curl_delete_call($url,$data)
{
	$headers=array(
		//'Authorization :'.$api_key,
		'Accept:application/json',
		'Content-Type:application/json'
	);
	$handle=curl_init();
	curl_setopt($handle,CURLOPT_URL,$url);
	curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "DELETE");
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	
	return $response;
}

function curl_delete_call_with_auth($url,$data,$api_key)
{
	$headers=array(
		'Authorization :'.$api_key,
		'Accept:application/json',
		'Content-Type:application/json'
	);
	$handle=curl_init();
	curl_setopt($handle,CURLOPT_URL,$url);
	curl_setopt($handle,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "DELETE");
	
	$response=curl_exec($handle);
	$code=curl_getinfo($handle,CURLINFO_HTTP_CODE);
	
	return $response;
}

//REST service call without curl

/** Using http_build_query() to build parameters */

/**
$data_array =array('title'=>'Mr','name'=>'Jason J','passport'=>'J7726458B');
$data = http_build_query($data_array);
 
//Now call the p2.php in HTTP POST by using function do_post_request
echo do_post_request('http://localhost/p2.php', $data);
*/

function do_post_request($url, $data, $optional_headers = null)
{
  	$params = array('http' => array(				
             'method' => 'POST',
             'content' => $data
        ));
  	if ($optional_headers !== null) 
	{
    	$params['http']['header'] = $optional_headers;
  	}
  	$ctx = stream_context_create($params);
  	$fp = @fopen($url, 'rb', false, $ctx);
  	if (!$fp) {
    	throw new Exception("Problem with $url, $php_errormsg");
  	}
  	$response = @stream_get_contents($fp);
  	if ($response === false) {
    	throw new Exception("Problem reading data from $url, $php_errormsg");
  	}
  	return $response;
}

//A Generic REST helper
function rest_helper($url, $params = null, $verb = 'GET', $format = 'json')
{
	$cparams = array(
			'http' => array(
			'method' => $verb,
			'ignore_errors' => true
    	)
  	);
  	if ($params !== null) {
    	$params = http_build_query($params);
    	if ($verb == 'POST') {
      		$cparams['http']['content'] = $params;
    	} else {
      		$url .= '?' . $params;
    	}
  	}

  	$context = stream_context_create($cparams);
  	$fp = fopen($url, 'rb', false, $context);
  	if (!$fp) {
    	$res = false;
  	} else {
		// If you're trying to troubleshoot problems, try uncommenting the
		// next two lines; it will show you the HTTP response headers across
		// all the redirects:
		// $meta = stream_get_meta_data($fp);
		// var_dump($meta['wrapper_data']);
		$res = stream_get_contents($fp);
  	}

  	if ($res === false) {
    	throw new Exception("$verb $url failed: $php_errormsg");
  	}

  	switch ($format) {
    	case 'json':
      	$r = json_decode($res);
      	if ($r === null) {
        	throw new Exception("failed to decode $res as json");
      	}
      	return $r;

    	case 'xml':
      	$r = simplexml_load_string($res);
      	if ($r === null) {
        	throw new Exception("failed to decode $res as xml");
      	}
      	return $r;
  	}
  	return $res;
}
?>