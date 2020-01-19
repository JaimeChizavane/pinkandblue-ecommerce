<?php
class Produtos extends Controller
{
	protected function index()
	{
		$viewmodel = new ProdutoModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar()
	{
		$viewmodel = new ProdutoModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function salvarMapa()
	{
		$model = new ProdutoModel;
		$model->salvar_mapa();
	}
	
	protected function remover()
	{
		$model = new ProdutoModel;
		$model->remover();
	}
	
	protected function novo()
	{
		$model = new ProdutoModel;
		$model->novo();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new ProdutoModel();
		$viewmodel->retornafoto();
	}
	
	protected function retornaGaleria()
	{
		$viewmodel = new ProdutoModel();
		$viewmodel->retornaGaleria();
	}

	protected function uploadfoto()
	{
		$viewmodel = new ProdutoModel();
		$viewmodel->uploadfoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new ProdutoModel();
		$viewmodel->removefoto();
	}
	
	protected function uploadGaleria()
	{
		$viewmodel = new ProdutoModel();
		$viewmodel->uploadGaleria();
	}
	
	protected function removeGaleria()
	{
		$viewmodel = new ProdutoModel();
		$viewmodel->removeGaleria();
	}
	
	protected function dashboard()
	{
		$viewmodel = new ProdutoModel;
		$this->returnView($viewmodel->dashboard(), true);
	}
	
	protected function agrupar()
	{
		$model = new ProdutoModel;
		$model->agrupar();
	}
}