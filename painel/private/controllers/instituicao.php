<?php
class Instituicao extends Controller{
	protected function Index(){
		$viewmodel = new InstituicaoModel();
		$this->returnView($viewmodel->Index(), true);
	}
	
	protected function salvar(){
		$viewmodel = new InstituicaoModel();
		$viewmodel->salvar();
	}
	
	protected function salvarMapa()
	{
		$model = new InstituicaoModel;
		$model->salvar_mapa();
	}
	
	protected function redes(){
		$viewmodel = new InstituicaoModel();
		$viewmodel->redes();
	}
	
	protected function retornaLogo(){
		$viewmodel = new InstituicaoModel();
		$viewmodel->retornaLogo();
	}
	
	protected function uploadLogo(){
		$viewmodel = new InstituicaoModel();
		$viewmodel->uploadLogo();
	}
}