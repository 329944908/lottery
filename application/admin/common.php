<?php
	function generate_number(){
		$cardNumber = mt_rand(10000,99999).time().mt_rand(10000,99999);
		return $cardNumber;
	}
	function generate_password($length=6) {  
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
		$cardPassword = ""; 
		for ( $i = 0; $i < $length; $i++ ){
			$cardPassword .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
		} 
		return $cardPassword; 
	} 