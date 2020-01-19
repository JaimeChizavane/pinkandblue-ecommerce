<?php
class Clientes extends Controller{
	
	protected function index(){
		$viewmodel = new ClienteModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new ClienteModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function novo()
	{
		$model = new ClienteModel;
		$model->novo();
	}
	
	protected function uploadfoto()
	{
		$viewmodel = new ClienteModel();
		$viewmodel->uploadfoto();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new ClienteModel();
		$viewmodel->retornafoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new ClienteModel();
		$viewmodel->removefoto();
	}
	
	protected function listarClientes()
	{
		$model = new ClienteModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarClientes($post);
	}
	
	protected function removerClientes()
	{
		$model 	= new ClienteModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerClientes($post);
	}
}