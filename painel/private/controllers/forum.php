<?php
class Forum extends Controller{
	
	protected function index(){
		$viewmodel = new ForumModel;
		$this->returnView($viewmodel->index(), true);
	}
	
	protected function listarForum()
	{
		$model = new ForumModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->listarForum($post);
	}
	
	protected function remover()
	{
		$model = new ForumModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->remover($post);
	}
	
	protected function activar()
	{
		$model = new ForumModel;
		$post   = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->activar($post);
	}
}