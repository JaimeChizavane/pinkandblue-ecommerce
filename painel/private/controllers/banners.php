<?php
class Banners extends Controller{
	
	protected function index(){
		$viewmodel = new BannerModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new BannerModel;
		$this->returnView($viewmodel->salvar(), true);
	}
	
	protected function novo()
	{
		$model = new BannerModel;
		$model->novo();
	}
	
	protected function uploadfoto()
	{
		$viewmodel = new BannerModel();
		$viewmodel->uploadfoto();
	}
	
	protected function retornafoto()
	{
		$viewmodel = new BannerModel();
		$viewmodel->retornafoto();
	}
	
	protected function removefoto()
	{
		$viewmodel = new BannerModel();
		$viewmodel->removefoto();
	}
	
	protected function listarBanners()
	{
		$model = new BannerModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarBanners($post);
	}
	
	protected function removerBanners()
	{
		$model 	= new BannerModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerBanners($post);
	}
	
	protected function retornaSubbanners()
	{
		$model 	= new BannerModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->retornaSubbanners($post);
	}
}