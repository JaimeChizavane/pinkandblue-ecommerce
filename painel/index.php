<?php
ob_start();
// Start Session
session_start();
// Include Config
require('config.php');
require('../config.php');
require('private/classes/Bootstrap.php');
require('private/classes/Controller.php');
require('private/classes/Model.php');
require('private/classes/mail/class.phpmailer.php');
require('private/classes/Email.php');
require('private/classes/Uteis.php');

require('private/controllers/home.php');
require('private/controllers/users.php');
require('private/controllers/banners.php');
require('private/controllers/imoveis.php');
require('private/controllers/automoveis.php');
require('private/controllers/produtos.php');
require('private/controllers/blog.php');
require('private/controllers/categorias.php');
require('private/controllers/clientes.php');
require('private/controllers/subcategorias.php');
require('private/controllers/marcas.php');
require('private/controllers/proprietarios.php');
require('private/controllers/forum.php');
require('private/controllers/bairros.php');
require('private/controllers/mensagens.php');
require('private/controllers/newsletters.php');
require('private/controllers/instituicao.php');
require('private/controllers/definicoes.php');

require('private/models/home.php');
require('private/models/user.php');
require('private/models/banner.php');
require('private/models/imovel.php');
require('private/models/automovel.php');
require('private/models/produto.php');
require('private/models/blog.php');
require('private/models/categoria.php');
require('private/models/cliente.php');
require('private/models/subCategoria.php');
require('private/models/marca.php');
require('private/models/proprietario.php');
require('private/models/forum.php');
require('private/models/bairro.php');
require('private/models/mensagem.php');
require('private/models/newsletter.php');
require('private/models/instituicao.php');
require('private/models/definicoes.php');

$bootstrap = new Bootstrap($_GET);
$controller = $bootstrap->createController();
if($controller){
	$controller->executeAction();
}
ob_end_flush();