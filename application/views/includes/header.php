<!-- Header File -->

<html>
	<head>
		<title><?=$title?></title>
		<!-- Link stylesheets here -->
	</head>
	<body>

	<div>
		<?php if($this->session->userdata('loggedIn')){ ?>
			Hi <?=$this->session->userdata('username')?>!
			<br/>
			<?=anchor(base_url('index.php/logout'), '<button>Logout</button>')?>
		<?php }else{ ?>
			<form action='<?=base_url('index.php/login')?>' method='post'>
				Username: <input type='text' name='username' required/>
				Password: <input type='password' name='password' required/>
				<input type='submit' name='submit' value='Login'/>
			</form>
		<?php } ?>
	</div>