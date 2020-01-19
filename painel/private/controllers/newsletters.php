<?php
class Newsletters extends Controller{
	protected function Index(){
		$viewmodel = new NewsletterModel();
		$this->returnView($viewmodel->Index(), true);
	}
	
	protected function listarNewsletters()
	{
		$model = new NewsletterModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarNewsletters($post);
	}
	
	protected function remover()
	{
		if(!isset($_SESSION['imovel_manage_user'])){
			header('Location: '.ROOT_URL.'users/login');
		}
		$viewmodel = new NewsletterModel();
		$viewmodel->remover();
	}
}