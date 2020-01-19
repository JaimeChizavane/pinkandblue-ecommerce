<?php
class Definicoes extends Controller
{
	protected function Index()
	{
		$viewmodel = new DefinicoesModel();
		$this->returnView($viewmodel->Index(), true);
	}
	
	protected function nova()
	{
		if(!isset($_SESSION['sms_manage_user'])){
			header('Location: '.ROOT_URL.'users/login');
		}
		$model = new DefinicoesModel();
		$model->nova();
	}

	protected function salvar()
	{
		if(!isset($_SESSION['sms_manage_user'])){
			header('Location: '.ROOT_URL.'users/login');
		}
		$viewmodel = new DefinicoesModel();
		$this->returnView($viewmodel->salvar(), true);
	}
}