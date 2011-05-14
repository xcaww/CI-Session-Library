<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>CodeIgniter</title>
	</head>
	
	<style type="text/css">
	
	body{
		background-color: #0b5ca1;
	}

	h1{
		font-family: 'Trebuchet MS', Helvetica, sans-serif;
		color: #323232;
		text-shadow: 0 1px 0 #1373c4;
		font-size: 28pt;
		margin-bottom: 6px;
	}
	
	h2{
		margin: 0;
		padding: 0;
	}
	
	p{
		padding: 0;
		margin: 0;
	}

	/* Error */

	#error_container {
		width: 620px;
		margin: 25px auto 0;
		padding: 14px;
	}

	#error_content {
		font-family: 'Trebuchet MS', Helvetica, sans-serif;
		background-color: #FFF;
		border: none;
		border-radius: 4px;
		padding: 5px;
	}

	#error_content h2 {	
		font-family: 'Trebuchet MS', Helvetica, sans-serif;
		color: #1b8ef0;
		font-size: 15pt;
		line-height: 15pt;
		margin-bottom: 10px;
	}

	#error_content p {
		color: #323232;
		font-size: 12pt;
	}

	</style>
	
	<body>

		<div id="error_container">
		
			<h1>Error</h1>

			<div id="error_content">
		
				<h2><?php echo $heading; ?></h2>
				<p>The page you were looking for does not seem to exist, or it is temporarily unavailable</p>
				<p>
				
			</div>
			
		</div>
	
	</body>
	
</html>