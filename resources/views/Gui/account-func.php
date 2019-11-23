<!DOCTYPE html>
<html>
	<head>
		<title>Account</title>
		<?php include("head.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/account.css">
	</head>
	<body>
		<header>
			<?php include("header.php");?>
		</header>
		<div class="wrapper">
			<?php include("account-banner.php");?>
			<div class="row">
				<div class="sm-col-span-12 lg-col-span-4">
				</div>
			</div>
		</div>
		<?php include("footer.php"); ?>
		<script>
			var data = '1';
			$(document).ready(function(){
				$('#test').on("click", function(){
					$.ajax({
						url: "account-surplus.php",
						type: 'GET',
						data: data,
						error: function(){
						},
						success: function(response){
							if(data == 'false'){
								alert('Error');
							}
							$('#wr').empty().append(response);
						}
					});
				});
			})
		</script>
	</body>
</html>