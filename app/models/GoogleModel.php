<?php 
class GoogleModel extends Model
{	
	public function google_get_data()
	{	
		if(isset($_GET['code']))
		{
			$gClient->authenticate($_GET['code']);
			$_SESSION['token'] = $gClient->getAccessToken();
			header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
		}

		if(isset($_SESSION['token']))
		{
			$gClient->setAccessToken($_SESSION['token']);		}

		if($gClient->getAccessToken())
		{
			// Get user profile data from google
			$gpUserProfile = $google_oauthV2->userinfo->get();
			
		}else
		{
			// Get login url
			$authUrl = $gClient->createAuthUrl();
			
			// Render google login button
			$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/google-sign-in-btn.png" alt=""/></a>';
		}
	}
}
	