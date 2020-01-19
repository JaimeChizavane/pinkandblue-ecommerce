<?php
class Proprietarios extends Controller{
	
	protected function index(){
		$viewmodel = new ProprietarioModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new ProprietarioModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function novo()
	{
		$model = new ProprietarioModel;
		$model->novo();
	}
	
	protected function uploadfoto()
	{
		$viewmodel = new ProprietarioModel();
		$viewmodel->uploadfoto();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new ProprietarioModel();
		$viewmodel->retornafoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new ProprietarioModel();
		$viewmodel->removefoto();
	}
	
	protected function listarProprietarios()
	{
		$model = new ProprietarioModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarProprietarios($post);
	}
	
	protected function removerProprietarios()
	{
		$model 	= new ProprietarioModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerProprietarios($post);
	}
}