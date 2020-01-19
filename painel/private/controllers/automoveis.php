<?php
class Automoveis extends Controller
{
	protected function index()
	{
		$viewmodel = new AutomovelModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar()
	{
		$viewmodel = new AutomovelModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function salvarMapa()
	{
		$model = new AutomovelModel;
		$model->salvar_mapa();
	}
	
	protected function remover()
	{
		$model = new AutomovelModel;
		$model->remover();
	}
	
	protected function novo()
	{
		$model = new AutomovelModel;
		$model->novo();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new AutomovelModel();
		$viewmodel->retornafoto();
	}
	
	protected function retornaGaleria()
	{
		$viewmodel = new AutomovelModel();
		$viewmodel->retornaGaleria();
	}

	protected function uploadfoto()
	{
		$viewmodel = new AutomovelModel();
		$viewmodel->uploadfoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new AutomovelModel();
		$viewmodel->removefoto();
	}
	
	protected function uploadGaleria()
	{
		$viewmodel = new AutomovelModel();
		$viewmodel->uploadGaleria();
	}
	
	protected function removeGaleria()
	{
		$viewmodel = new AutomovelModel();
		$viewmodel->removeGaleria();
	}
	
	protected function importar()
	{
		$viewmodel = new AutomovelModel;
		$this->returnView($viewmodel->importar(), true);
	}
	
	protected function agrupar()
	{
		$model = new AutomovelModel;
		$model->agrupar();
	}
}