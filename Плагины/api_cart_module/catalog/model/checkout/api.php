<?php

class ModelCheckoutApi extends Model {

public function getAPI()
	{
		require_once('lib/nusoap.php');
		require_once('api.lib.php');
		set_time_limit(180);
		
		$login="***";
		$pass="***";
		$site_id=***;
		$api=new AS_API($login, md5($pass), "http://api.apishops.com/services/API?wsdl", $site_id);
		if(!$api->checkConnection())
		return 0;
		else
		return $api;
	}

}