<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Painel Administrativo</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="url" content="<?php echo ROOT_URL;?>">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/dev.css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/dev-theme.css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/font-awesome/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", Arial, Helvetica, sans-serif}
	p{margin:0;}
</style>
</head>
<body class="">
<!-- Links (sit on top) -->

<div class="dev-border login">
	
	<form name="login">
		<div class="dev-panel dev-display-container j_alert" style="display:none;"></div>
		<div class="dev-container j_spin" style="display:none;">
			  <p style="text-align:center"><i class="fa fa-spinner dev-spin" style="font-size:64px;"></i></p>
		</div>
	  <div class="container">
		<label for="uname"><b>Email: </b></label>
		<input type="text" placeholder="Informe o email" name="email" required>

		<label for="psw"><b>Senha: </b></label>
		<input type="password" placeholder="informe a senha" name="senha_visivel" required>		
		<label>
		  <input type="checkbox" checked="checked" name="checked"> Mantenha-me conectado
		</label>
		<input type="submit" value="Entrar" class="dev-flat-peter-river j_login">
	  </div>

	  <div class="container" style="background-color:#f1f1f1;overflow:auto;">
		<span class="psw">Esqueci <a href="#">minha Senha?</a></span>
	  </div>
	</form>
<style>
	/* Bordered form */
form {
    border: 3px solid #f1f1f1;
}

/* Full-width inputs */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button,input[type="submit"] {
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Add a hover effect for buttons */
button:hover,,input[type="submit"]:hover {
    opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the avatar image inside this container */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

/* Avatar image */
img.avatar {
    width: 40%;
    border-radius: 50%;
}

/* Add padding to containers */
.container {
    padding: 16px;
}

/* The "Forgot password" text */
span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
        display: block;
        float: none;
    }
    .cancelbtn {
        width: 100%;
    }
}
</style>
<script src="<?php echo ROOT_URL;?>assets/js/jquery.js"></script>
<script src="<?php echo ROOT_URL;?>assets/controllers/users.js"></script>
</div>
</body></html>