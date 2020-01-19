<?php
class Users extends Controller
{
	protected function Index(){
		$viewmodel = new UserModel;
		$this->returnView($viewmodel->Index(), true);
	}

	protected function login(){
		$viewmodel = new UserModel;
		$this->returnView($viewmodel->login(), false);
	}
	
	protected function autenticaUser()
	{
		$model = new UserModel;
		$model->autenticaUser();
	}
	
	protected function novo(){
		$model = new UserModel;
		$model->novo();
	}
	
	protected function listarUsers()
	{
		$model = new UserModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarUsers($post);
	}
	
	protected function salvar()
	{
		$viewmodel = new UserModel;
		$this->returnView($viewmodel->salvar(),true);
	}
	
	protected function senha()
	{
		$model = new UserModel;
		$model->senha();
	}
	
	protected function removerUsers()
	{
		$model 	= new UserModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->removerUsers($post);
	}
	
	protected function newsletterSubscribe()
	{
		$model = new UserModel();
		$model->newsletterSubscribe();
	}
	
	protected function pesquisaContacto()
	{
		$model = new UserModel();
		$model->pesquisaContacto();
	}
	
	protected function procuro()
	{
		$model = new UserModel();
		$model->procuro();
	}

	protected function logout()
	{
		$model = new UserModel;
		$model->logout();
	}
}