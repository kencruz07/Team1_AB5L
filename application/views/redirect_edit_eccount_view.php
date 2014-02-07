<html>
<head>
	<title>ICS Library System | Edit User Profile</title>
</head>

	<body>

			<?php 
				foreach ($data as $row){
				}
			?>
				ID: <?php echo $row->id; ?>
				Employee No: <?php echo $row->employee_number; ?> <br/>
				Student Number: <?php echo $row->student_number; ?> <br/>
				Last name: <?php echo $row->last_name; ?> <br/>
				First name: <?php echo $row->first_name; ?> <br/>
				Middle name: <?php echo $row->middle_name; ?> <br/>
				User type: <?php echo $row->user_type; ?> <br/>
				Username: <?php echo $row->username; ?> <br/>
				Password: <?php echo $row->password; ?> <br/>
				College Address: <?php echo $row->college_address; ?> <br/>
				Email Address: <?php echo $row->email_address;?> <br/>
				Contact Number: <?php echo $row->contact_number; ?> <br/>
				Borrow Limit: <?php echo $row->borrow_limit; ?> <br/>
				Waitlist Limit: <?php echo $row->waitlist_limit; ?> <br/>
				College: <?php echo $row->college; ?> <br/>
				Degree: <?php echo $row->degree; ?> <br/>
			
	</body>
<?=$this->load->view('includes/footer')?>

</html>