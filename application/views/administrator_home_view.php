<!-- Administrator Home Page -->

<?=$this->load->view('includes/header')?>

	<?php if(isset($notification_message)){echo '<script> alert("You successfully created the account") </script>';} ?>
	
	<?=anchor(base_url('index.php/administrator/create_account'), 'Create Account')?>
	<?=anchor(base_url('index.php/administrator/view_accounts'), 'View Accounts')?>

<?=$this->load->view('includes/footer')?>