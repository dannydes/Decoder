<?php

$punctuation_map = array(
	'.' => 1,
	'?' => 2,
	'!' => 3,
	',' => 4,
	'"' => 5,
	'\'' => 6,
	' ' => 7,
);

function encrypt($plaintext) {
	$cyphertext = '';
	
	// Generate first 200 random characters
	$vowels = 0;
	$first = 0;
	for ($i = 0; $i < 200; $i++) {
		$char = generate_random();
		$cyphertext .= $char;
		if (is_vowel($char)) {
			$vowels++;
			if ($vowels === 5) {
				$first = $i;
			}
		}
	}
	
	// Fill gap to first character of the plaintext with random characters
	for ($i = 0; $i < $first; $i++) {
		$cyphertext .= generate_random();
	}
	
	//Generate the last 200 character-block to be appended later
	$last_block = '';
	$vowels = 0;
	$gap = 0;
	for ($i = 0; $i < 200; $i++) {
		$char = generate_random();
		$last_block = $char . $last_block;
		if (is_vowel($char)) {
			$vowels++;
			if ($vowels === 3) {
				$gap = $i;
			}
		}
	}
	
	// Generate the message block
	global $punctuation_map;
	for ($i = 0; $i < strlen($plaintext); $i++) {
		$cyphertext .= empty($punctuation_map[$plaintext[$i]]) ?
				$plaintext[$i] :
				
				//Translate punctuation accordingly
				$punctuation_map[$plaintext[$i]];
		
		// Fill in the gaps
		for ($j = 0; $j < $gap; $j++) {
			$cyphertext .= generate_random();
		}
	}
	
	// Append $first
	$cyphertext .= $first;
	
	// Gap before appending $gap
	for ($i = 0; $i < $gap; $i++) {
		$cyphertext .= generate_random();
	}
	
	// Append $gap
	$cyphertext .= $gap;
	
	// Append the last block
	$cyphertext .= $last_block;
	
	return $cyphertext;
}

function decrypt($cyphertext) {
	// Strip first and last 200-character-blocks
	$message = substr($cyphertext, 200, strlen($cyphertext) - 400);
	
	// Get $gap
	$num_str = '';
	for ($i = strlen($message) - 1; is_numeric($message[$i]); $i--) {
		$num_str = $message[$i] . $num_str;
	}
	$gap = intval($num_str);
	
	// Strip $gap and it's gap
	$message = substr($message, 0, $i + 1 - $gap);
	
	// Get $first
	$num_str = '';
	for ($i = strlen($message) - 1; is_numeric($message[$i]); $i--) {
		$num_str = $message[$i] . $num_str;
	}
	$first = intval($num_str);
	
	// Strip the characters preceeding message block and $first and it's gap
	$message = substr($message, $first, strlen($message) - $i + 1 - $gap);
	
	// Generate plaintext
	global $punctuation_map;
	$plaintext = '';
	for ($i = 0; $i < strlen($message); $i++) {
		$plaintext .= in_array($message[$i], $punctuation_map) ?
			
			// Map character to the proper punctuation
			array_search($message[$i], $punctuation_map) :
			
			$message[$i];
		
		// Skip the gap
		for ($j = 0; $j < $gap; $j++, $i++);
	}
	
	return $plaintext;
}

function is_vowel($char) {
	return $char === 'A' ||
		$char === 'E' ||
		$char === 'I' ||
		$char === 'O' ||
		$char === 'U' ||
		$char === 'a' ||
		$char === 'e' ||
		$char === 'i' ||
		$char === 'o' ||
		$char === 'u';
}

function generate_random() {
	return chr(rand(65, 122));
}