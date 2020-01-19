<?php
	//define a url root do template
	$FOLDER = '/quickmaputo/';
	define('ROOT','http://'.$_SERVER['HTTP_HOST'].$FOLDER);	
	// Define URL
	define("ROOT_URL", ROOT."painel/");	
	//define o template activo
	define('TEMPLATE',"main/");	
	//define a url para os recursos do template
	define('TEMPLATE_PATH',ROOT_URL."public/templates/".TEMPLATE);
?>