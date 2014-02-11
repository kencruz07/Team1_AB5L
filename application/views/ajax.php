<!doctype html>
<html>
<head>
<script type="text/javascript" src="<?php echo base_url("js/jquery-2.0.3.min.js"); ?>"></script>
	<script>
		function list3(){
			var input = $("#input").val();
			$.ajax({
				type: 'POST',
				url: 'http://localhost/Team1_AB5L/index.php/administrator/list1',
				data: 'input='+input,
				success: function(result){
					if(result == "true"){
						$("#result").html("Hindi Okay");
					}
					else $("#result").html("Okay lang");
				}
			});
		}
	</script>
</head>
	<body>
	<input type="text" id="input" onblur="list3();" />
	<div id="result"></div>
	</body>
</html>