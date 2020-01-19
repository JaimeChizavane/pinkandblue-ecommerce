<?php
class Mensagens extends Controller{
	protected function Index()
	{
		$viewmodel = new MensagemModel();
		$this->returnView($viewmodel->Index(), true);
	}
	
	protected function enviar()
	{
		$viewmodel = new MensagemModel();
		$this->returnView($viewmodel->enviar(), true);
	}
	
	protected function ver()
	{
		$viewmodel = new MensagemModel();
		$this->returnView($viewmodel->ver(), true);
	}
	
	protected function imovel()
	{
		$viewmodel = new MensagemModel();
		$this->returnView($viewmodel->imovel(), true);
	}
	
	protected function salvar()
	{
		$viewmodel = new MensagemModel();
		$viewmodel->salvar();
	}
	
	protected function remover()
	{
		$viewmodel = new MensagemModel();
		$viewmodel->remover();
	}
	
	protected function email()
	{
		$viewmodel = new MensagemModel();
		$this->returnView($viewmodel->email(), true);
	}
	
	protected function listarMensagens()
	{
		$model 	= new MensagemModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarMensagens($post);
	}
}