<?php
class Marcas extends Controller{
	
	protected function index(){
		$viewmodel = new MarcaModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new MarcaModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function novo()
	{
		$model = new MarcaModel;
		$model->novo();
	}
	
	protected function uploadfoto()
	{
		$viewmodel = new MarcaModel();
		$viewmodel->uploadfoto();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new MarcaModel();
		$viewmodel->retornafoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new MarcaModel();
		$viewmodel->removefoto();
	}
	
	protected function listarMarcas()
	{
		$model = new MarcaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarMarcas($post);
	}
	
	protected function removerMarcas()
	{
		$model 	= new MarcaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerMarcas($post);
	}
}