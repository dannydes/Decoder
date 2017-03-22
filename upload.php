<?php

require 'functions.php';

if ($_POST['option'] === 'plain') {
	echo encrypt($_POST['upload']);
} else {
	echo decrypt($_POST['upload']);
}