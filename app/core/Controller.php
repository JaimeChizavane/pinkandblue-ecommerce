<?php 
class Controller
{
	
	protected function model($model)
	{
		if(file_exists('app/models/'. $model .'.php'))
		{
			require_once 'app/models/'. $model .'.php';
			return new $model;
		}		
	}
	
	protected function returnView($viewmodel, $data = [], $fullview, $template_folder = "")
	{
		$view = "painel/public/templates/".TEMPLATE.$viewmodel.'.php';
		if($fullview)
		{
			require_once("painel/public/templates/".TEMPLATE.$template_folder.'main.php');
		}else{
			require_once($view);
		}
				
	}
}