<html>
<head>
	<title>ICS Library System | Edit User Profile</title>
</head>

	<body>
			<form action="<?=base_url().'index.php/administrator/save_account_changes'?>" method='post'>

			<?php 
				foreach ($account as $row){
				}
			?>
				<!--Removed showing row id-->
				Employee No: <input type='text' name='employee_no' pattern="[0-9]{9}" value="<?php echo $row->employee_number; ?>" /> <br/>
				Student Number: <input type='text' name='stud_no' pattern="[\-0-9]{10}" value='<?php echo $row->student_number; ?>' /><br/>
				Last name: <input type='text' name='last_name' pattern="[A-Za-z]{1,35}" value='<?php echo $row->last_name; ?>' required/><br/>
				First name: <input type='text' name='first_name' pattern="[A-Z\ a-z]{1,35}" value='<?php echo $row->first_name; ?>' required/><br/>
				Middle name: <input type='text' name='middle_name' pattern="[A-Z\ a-z]{1,35}" value='<?php echo $row->middle_name; ?>' /><br/>
				User type: <input type='text' name='user_type' value='<?php echo $row->user_type; ?>' /><br/>
				Username: <input type='text' name='username' pattern="[A-Za-z_0-9]{1,15}" value= '<?php echo $row->username; ?>' required/> <br/>
				Password: <input type='password' name='password' value= '<?php echo $row->password; ?>' /><br/>
				College Address: <input type='text' name='college_address' pattern="[A-Za-z\ 0-9]{1,55}" value='<?php echo $row->college_address; ?>' /><br/>
				Email Address: <input type='email' pattern="[A-Za-z_@\.	0-9]{1,45}" name='email_address' value='<?php echo $row->email_address;?>' /><br/>
				Contact Number: <input type='text' pattern="[\-0-9]{1,12}" name='contact' value='<?php echo $row->contact_number; ?>' /><br/>
				Borrow Limit: <?php echo $row->borrow_limit; ?> <br/>
				Waitlist Limit: <?php echo $row->waitlist_limit; ?> <br/>
				College: <input type='text' name='college' value='<?php echo $row->college; ?>' /><br/>
				Degree: <input type='text' name='degree' value='<?php echo $row->degree; ?>' /><br/>

			<input type="submit" name="submit" value="Save Changes"/>
			</form>
			
	</body>
<?=$this->load->view('includes/footer')?>

</html>