<?php
class Categorias extends Controller{
	
	protected function index(){
		$viewmodel = new CategoriaModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new CategoriaModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function novo()
	{
		$model = new CategoriaModel;
		$model->novo();
	}
	
	protected function uploadfoto()
	{
		$viewmodel = new CategoriaModel();
		$viewmodel->uploadfoto();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new CategoriaModel();
		$viewmodel->retornafoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new CategoriaModel();
		$viewmodel->removefoto();
	}
	
	protected function listarCategorias()
	{
		$model = new CategoriaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarCategorias($post);
	}
	
	protected function removerCategorias()
	{
		$model 	= new CategoriaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerCategorias($post);
	}
	
	protected function retornaSubcategoriaseMarcas()
	{
		$model 	= new CategoriaModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->retornaSubcategoriaseMarcas($post);
	}
}