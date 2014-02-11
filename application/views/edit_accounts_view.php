<!--
		Description: EDIT ACCOUNTS PAGE INCLUDING FORM FIELDS FOR EDITING USER'S ACCOUNT INFORMATION
		Author: Zinnia Kale A. Malabuyoc
		Last Modified: February 11, 2014
-->

<!DOCTYPE html>
<html>
<head>
	<title>ICS Library System | Edit User Profile</title>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-2.0.3.min.js"); ?>"></script>
	<script>
		function checkUsername(){
			var input = $("#input").val();
			$.ajax({
				type: 'POST',
				url: 'http://localhost/Team1_AB5L/index.php/administrator/check_username',
				data: 'input='+input,
				success: function(result){
					if(result == "false"){
						alert("Username already exists!");
					}
				}
			});
		}
	</script>
</head>

	<body>
			<form action="<?=base_url().'index.php/administrator/save_account_changes'?>" method='post'>

			<?php 
				foreach ($account as $row){
				}
			?>
				<!--
				CHANGES MADE: 
				 - NO NEED TO PRINT BORROW LIMIT AND WAITLIST LIMIT SINCE IT IS PERMANENT
				 - PATTERNS REVISED
				 - CHECKS IF USERNAME ALREADY EXISTS
				-->
				Employee No: <input type='text' name='employee_no' pattern='[0-9]{9}' value="<?php echo $row->employee_number; ?>" /> <br/>
				Student Number: <input type='text' name='stud_no' pattern='[\-0-9]{10}' value='<?php echo $row->student_number; ?>' /><br/>
				Last name: <input type='text' name='last_name' pattern='[A-Za-z\s]{1,35}' value='<?php echo $row->last_name; ?>' required/><br/>
				First name: <input type='text' name='first_name' pattern='[A-Z\sa-z]{1,35}' value='<?php echo $row->first_name; ?>' required/><br/>
				Middle name: <input type='text' name='middle_name' pattern='[A-Z\sa-z]{1,35}' value='<?php echo $row->middle_name; ?>' /><br/>
				User type: <input type='text' name='user_type' value='<?php echo $row->user_type; ?>' required/><br/>
				Username: <input type='text' name='username' id='uname' pattern='[A-Za-z_0-9]{1,15}' value= '<?php echo $row->username; ?>' onblur="checkUsername()" required/> <br/>
				Password: <input type='password' name='password' value= '<?php echo $row->password; ?>' /><br/>
				College Address: <input type='text' name='college_address' pattern='[A-Za-z\s0-9\.\,]{1,55}' value='<?php echo $row->college_address; ?>' /><br/>
				Email Address: <input type='email' pattern='[A-Za-z_@\.0-9]{1,45}' name='email_address' value='<?php echo $row->email_address;?>' /><br/>
				Contact Number: <input type='text' pattern='[\+\-0-9]{1,13}' name='contact' value='<?php echo $row->contact_number; ?>' /><br/>
				College: <input type='text' name='college' value='<?php echo $row->college; ?>' /><br/>
				Degree: <input type='text' name='degree' value='<?php echo $row->degree; ?>' /><br/>

			<input type="submit" name="submit" value="Save Changes"/>
			</form>
			
	</body>

<?=$this->load->view('includes/footer')?>

</html>