<?php
class Imoveis extends Controller
{
	protected function index()
	{
		$viewmodel = new ImovelModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar()
	{
		$viewmodel = new ImovelModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function salvarMapa()
	{
		$model = new ImovelModel;
		$model->salvar_mapa();
	}
	
	protected function remover()
	{
		$model = new ImovelModel;
		$model->remover();
	}
	
	protected function novo()
	{
		$model = new ImovelModel;
		$model->novo();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new ImovelModel();
		$viewmodel->retornafoto();
	}
	
	protected function retornaGaleria()
	{
		$viewmodel = new ImovelModel();
		$viewmodel->retornaGaleria();
	}

	protected function uploadfoto()
	{
		$viewmodel = new ImovelModel();
		$viewmodel->uploadfoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new ImovelModel();
		$viewmodel->removefoto();
	}
	
	protected function uploadGaleria()
	{
		$viewmodel = new ImovelModel();
		$viewmodel->uploadGaleria();
	}
	
	protected function removeGaleria()
	{
		$viewmodel = new ImovelModel();
		$viewmodel->removeGaleria();
	}
	
	protected function importar()
	{
		$viewmodel = new ImovelModel;
		$this->returnView($viewmodel->importar(), true);
	}
	
	protected function agrupar()
	{
		$model = new ImovelModel;
		$model->agrupar();
	}
}