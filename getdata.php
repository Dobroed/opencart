<?php 
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
   die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db("opencart")) {
   echo "Unable to select mydbname: " . mysql_error();
   exit;
}
if(isset($_REQUEST['q']) && $_REQUEST['q']!=''){
	$q = mysql_real_escape_string($_REQUEST['q']);
	
	$sql = "SELECT pd.name FROM oc_product p,oc_product_description pd WHERE p.product_id = pd.product_id AND UPPER(pd.name) like UPPER('$q%') GROUP BY pd.product_id ORDER BY pd.name ASC"; 
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0){
		while($ro = mysql_fetch_assoc($res)){
			
			$name = str_replace( array( '\'', '"', ',' , ';', '<', '>','&quot','&'), ' ', $ro['name']);
			$str[]= $name."\n";
		}
	}
	
	echo json_encode($str);
}

?>