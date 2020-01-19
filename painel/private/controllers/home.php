<?php
class Home extends Controller{
	protected function Index(){
		if(!isset($_SESSION['manage_user'])){
			header('Location: '.ROOT_URL.'users/login');
		}
		$viewmodel = new HomeModel();
		$this->returnView($viewmodel->Index(), true);
	}
}