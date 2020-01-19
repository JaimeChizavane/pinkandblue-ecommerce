<? 
class GoogleApiLogin  extends Controller
{
	// Google API configuration
	private google_client_id 		= "365895823879-meno05tl63b7m8e2ou7ldkldrgsm6f1i.apps.googleusercontent.com";
	private google_client_secret 	= "Pg0dudcKLLhGp-cMOC2Guruz";
	private google_redirect_url 	= "http://localhost/quickmaputo/cliente/pagamentos";

	public function __construct()
	{
		// Include Google API client library
		require_once __DIR__.'../google-api-php-client-master/src/Google/autoload.php';

		// Call Google API
		$gClient = new Google_Client();
		$gClient->setApplicationName('Web login app quickmaputo');
		$gClient->setClientId($this->google_client_id);
		$gClient->setClientSecret($this->google_client_secret);
		$gClient->setRedirectUri($this->google_redirect_url);

		$google_oauthV2 = new Google_Oauth2Service($gClient);
		
	}
	
	public function index()
	{
		$model 		= $this->model('GoogelModel');
		$model->google_get_data();		
	}

}