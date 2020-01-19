<?php
class Bairros extends Controller{
	
	protected function index(){
		$viewmodel = new BairroModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new BairroModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	protected function novo()
	{
		$model = new BairroModel;
		$model->novo();
	}
	
	protected function listarBairros()
	{
		$model = new BairroModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarBairros($post);
	}
	
	protected function removerBairros()
	{
		$model 	= new BairroModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerBairros($post);
	}
}