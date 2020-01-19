<?php 
ob_start();
session_start();
require_once "painel/config.php";
require_once "painel/private/classes/Model.php";
require_once "app/uteis/Uteis.php";	
require_once "app/init.php";
ob_end_flush();