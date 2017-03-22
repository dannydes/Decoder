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
	$vowel_5 = 0;
	$cyphertext = '';
	
	// Generate first 200 random characters
	for ($i = 0; $i < 200; $i++) {
		$char = generate_random();
		$cyphertext .= $char;
		if (is_vowel($char)) {
			$vowels++;
			if ($vowels === 5) {
				$vowel_5 = $i;
			}
		}
	}
	
	// Fill gap to first character of the plaintext with random characters
	for ($i = 0; $i < $vowel_5; $i++) {
		$cyphertext .= generate_random();
	}
	
	// Translate punctuation accordingly
	global $punctuation_map;
	$code = '';
	for ($i = 0; $i < strlen($plaintext); $i++) {
		$code .= empty($punctuation_map[$plaintext[$i]]) ? $plaintext[$i] : $punctuation_map[$plaintext[$i]];
	}
	
	$cyphertext .= $code;
	for ($i = 0; $i < 200; $i++) {
		$cyphertext .= generate_random();
	}
	return $cyphertext;
}

function decrypt($cyphertext) {
	$vowel_5 = 0;
	for ($vowels = 0, $i = 0; $vowels < 5 && $i < 200; $i++) {
		if (is_vowel($cyphertext[$i])) {
			$vowels++;
			if ($vowels === 5) {
				$vowel_5 = $i;
			}
		}
	}
	$code = substr($cyphertext, 200 + $vowel_5, strlen($cyphertext) - 400 - $vowel_5);
	
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