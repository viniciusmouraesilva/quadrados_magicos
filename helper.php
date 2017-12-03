<?php
function verificarColuna($coluna) {
	
	switch($coluna) {
		case 'a':
			return true;
			break;
		case 'b':
			return true;
			break;
		case 'c':
			return true;
			break;
		case 'd':
			return true;
			break;
		default:
			return false;
			break;
	}
	
}

function verificarLinha($linha) {
	
	switch($linha) {
		case 1:
			return true;
			break;
		case 2:
			return true;
			break;
		case 3:
			return true;
			break;
		case 4:
			return true;
			break;
		default:
			return false;
			break;
	}
}

function verificar_numero_digitado($numero, $coluna, $linha) {
	
	$indice_letras_f = array('a','b','c','d');
	$indice_f = 0;
	$indice_letra_verificar = '';
	$ind_session = 0;
	$ind = 0;
	
	for($i=0;$i<=18;$i++) {
		
		if($ind <= 3) {
			
			$indice_letra_verificar = $indice_letras_f[$indice_f];
			
			print $indice_letra_verificar;
			
			//print $_SESSION["{$indice_letra_verificar}"][$ind_session];
			
			if($_SESSION["{$indice_letra_verificar}"][$ind_session] == $numero) {
				 if($coluna !== $indice_letra_verificar) {
					$_SESSION["{$indice_letra_verificar}"][$ind_session] = 0; 
				 }elseif($coluna == $indice_letra_verificar && $ind_session !== $linha) {
					$_SESSION["{$indice_letra_verificar}"][$ind_session] = 0;
				 }
			}
			
			$ind_session++;
		}else {
			$ind_session = 0;
			$indice_f++;
		}
		if($ind_session == 0) {
			$ind = 0;
		}else {	
			$ind++;
		}
	}
}