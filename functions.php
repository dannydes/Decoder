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
	$vowels = 0;
	$first = 0;
	$cyphertext = '';
	
	// Generate first 200 random characters
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
	
	
	
	// Append the last block
	$cyphertext .= $last_block;
	
	return $cyphertext;
}

function decrypt($cyphertext) {
	$first = 0;
	for ($vowels = 0, $i = 0; $vowels < 5 && $i < 200; $i++) {
		if (is_vowel($cyphertext[$i])) {
			$vowels++;
			if ($vowels === 5) {
				$first = $i;
			}
		}
	}
	$code = substr($cyphertext, 200 + $first, strlen($cyphertext) - 400 - $first);
	
	global $punctuation_map;
	$plaintext = '';
	for ($i = 0; $i < strlen($code); $i++) {
		$plaintext .= in_array($code[$i], $punctuation_map) ? array_search($code[$i], $punctuation_map) : $code[$i];
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