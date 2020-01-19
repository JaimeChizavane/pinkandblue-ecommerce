<?php
class Subcategorias extends Controller{
	
	protected function index(){
		$viewmodel = new SubcategoriaModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new SubcategoriaModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function novo()
	{
		$model = new SubcategoriaModel;
		$model->novo();
	}
	
	protected function uploadfoto()
	{
		$viewmodel = new SubcategoriaModel();
		$viewmodel->uploadfoto();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new SubcategoriaModel();
		$viewmodel->retornafoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new SubcategoriaModel();
		$viewmodel->removefoto();
	}
	
	protected function listarSubcategorias()
	{
		$model = new SubcategoriaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarSubcategorias($post);
	}
	
	protected function removerSubcategorias()
	{
		$model 	= new SubcategoriaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerSubcategorias($post);
	}
}