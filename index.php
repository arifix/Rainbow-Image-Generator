<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rainbow Image Generator</title>
	<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<style>
		.container:nth-child(1){margin: 20px auto;}
	</style>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form class="form-inline" id="myForm" action="process.php" method="post" enctype="multipart/form-data">
        			<input type="file" name="upload" class="form-control" required="true" />
        			<button class="btn btn-success" id="submit" name="submit" type="submit">Generate Image</button>
				</form>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="progress" style="display:none;">
  					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
				</div>
				<span class="complete" style="display:none;">0% Complete</span>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="notice" id="result"></div>
			</div>
		</div>
	</div>

	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script> 
	<script src="script.js"></script>
	
</body>
</html>
