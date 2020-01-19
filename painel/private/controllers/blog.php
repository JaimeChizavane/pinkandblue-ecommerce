<?php
class Blog extends Controller
{
	protected function index()
	{
		$viewmodel = new BlogModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar()
	{
		$viewmodel = new BlogModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function salvarMapa()
	{
		$model = new BlogModel;
		$model->salvar_mapa();
	}
	
	protected function remover()
	{
		$model = new BlogModel;
		$model->remover();
	}
	
	protected function novo()
	{
		$model = new BlogModel;
		$model->novo();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new BlogModel();
		$viewmodel->retornafoto();
	}
	
	protected function retornaGaleria()
	{
		$viewmodel = new BlogModel();
		$viewmodel->retornaGaleria();
	}

	protected function uploadfoto()
	{
		$viewmodel = new BlogModel();
		$viewmodel->uploadfoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new BlogModel();
		$viewmodel->removefoto();
	}
	
	protected function uploadGaleria()
	{
		$viewmodel = new BlogModel();
		$viewmodel->uploadGaleria();
	}
	
	protected function removeGaleria()
	{
		$viewmodel = new BlogModel();
		$viewmodel->removeGaleria();
	}
	
	protected function importar()
	{
		$viewmodel = new BlogModel;
		$this->returnView($viewmodel->importar(), true);
	}
	
	protected function agrupar()
	{
		$model = new BlogModel;
		$model->agrupar();
	}
}