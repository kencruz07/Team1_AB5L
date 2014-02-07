<?=$this->load->view('includes/header')?>

	<?php if(isset($notification_message)){echo '<script> alert("You successfully created the account") </script>';} ?>
	
	<a href="<?=base_url().'index.php/administrator/view_accounts'?>">View Accounts</a>	
	<a href="<?=base_url().'index.php/administrator/create_account'?>">Create Account</a>

<?=$this->load->view('includes/footer')?>