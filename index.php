<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Decoder</title>
	</head>
	<body>
		<form action="#" id="upload-form">
			<input type="radio" id="plaintext-option" name="option" value="plain">
			<label for="plaintext-option">Plaintext</label>
			<input type="radio" id="cyphertext-option" name="option" value="cypher">
			<label for="cyphertext-option">Cyphertext</label><br>
			<label for="upload">Upload file</label>
			<input type="file" id="upload" name="upload"><br>
			<input type="submit" value="submit">
		</form>
		<div id="view"></div>
<?php

require 'functions.php';

$cyphertext = encrypt('hello!!');

echo $cyphertext;

?>
		<br>
		<?php echo decrypt($cyphertext); ?>
		<script src="jquery-3.2.0.min.js"></script>
		<script src="script.js"></script>
	</body>
</html>