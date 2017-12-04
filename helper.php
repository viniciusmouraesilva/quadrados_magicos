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

function totalColuna() {
	
	$letras_indice = array('a','b','c','d');
	$ind = 0;
	$total = array('a','b','c','d');
	$letra = '';
	
	$controle_letras = 0;
	
	for($i=0;$i<=18;$i++) {
		
		if($ind <= 3) {
			
			$letra = $letras_indice["{$controle_letras}"];
			
			$total[$controle_letras] += $_SESSION["{$letra}"][$ind];
			
			$ind++;
		}else {
			$ind = 0;
			$controle_letras++;
		}
	}
	
	if(array_key_exists('totalC',$_SESSION)) {
		unset($_SESSION['totalC']);
		$_SESSION['totalC'] = $total;
	}else {
		$_SESSION['totalC'] = $total;
	}
	
	foreach($total as $coluna) {
		print "<td>". $coluna . "</td>";
	}
}

function totalLinha() {
	
	$letras_indice = array('a','b','c','d');
	$ind = 0;
	$total = array('a','b','c','d');
	$letra = '';
	$ind_contador = 0;
	$controle_letras = 0;
	$indice_principal = 0;
	
	for($i=0;$i<=18;$i++) {
		
		if($ind_contador <= 3) {
			
			$letra = $letras_indice["{$controle_letras}"];
			
			$total[$indice_principal] += $_SESSION["{$letra}"][$ind];
			
			$controle_letras++;
			$ind_contador++;
		}else {
			$indice_principal++;
			$ind_contador = 0;
			$controle_letras = 0;
			$ind++;
		}
	}
	
	if(array_key_exists('totalL',$_SESSION)) {
		unset($_SESSION['totalL']);
		$_SESSION['totalL'] = $total;
	}else {
		$_SESSION['totalL'] = $total;
	}
	
	foreach($total as $linha) {
		print "<td>". $linha . "</td>";
	}
}

function totalDiagonalAD() {

	$indice_letras = array('a','b','c','d');
	$ind = 0;
	$indice = 0;
	$array_pesquisa = array('0'=>'0','1'=>'0');
	$indice_para_total = 0;
	$letra = '';
	
	for($i=0;$i<=7;$i++) {
		
		if($indice_para_total == 0) {
			if($ind <= 3) {
		
				$letra = $indice_letras[$indice];
			
				$array_pesquisa[$indice_para_total] += $_SESSION["{$letra}"][$indice];
				
				$indice++;
				$ind++;
			}else {
				$indice = 0;
				$ind  = 0;
				$indice_para_total++;
				$indice_extra = 3;
			}
		}else {
			if($ind <= 3) {
				
				if($ind == 0) {
					$i--;
				}
				
				$letra = $indice_letras[$indice_extra];
				
				$array_pesquisa[$indice_para_total] += $_SESSION["{$letra}"][$indice];	
				
				$indice_extra--;
				
				$indice++;
				
				$ind++;
			}
		}
	}
	
	if(array_key_exists('totalD',$_SESSION)) {
		unset($_SESSION['totalD']);
		$_SESSION['totalD'] = $array_pesquisa;
	}else {
		$_SESSION['totalD'] = $array_pesquisa;
	}
	
	foreach($array_pesquisa as $result) {
		print "<td>". $result ."</td>";
	}
}

function verificarVitoria() {

	if(array_key_exists('ganhou',$_SESSION)) {
		$_SESSION['ganhou'] = false;
	}
	

	$i = 0;
	
	if(is_array($_SESSION['totalC'])) {
		foreach($_SESSION['totalC'] as $total) {
			if($total == 34) {
				$i++;
			}
		}
	}
	
	if(is_array($_SESSION['totalL'])) {
		foreach($_SESSION['totalL'] as $total) {
			if($total == 34) {
				$i++;
			}
		}
	}
	
	if(is_array($_SESSION['totalD'])) {
		foreach($_SESSION['totalD'] as $total) {
			if($total == 34) {
				$i++;
			}
		}
	}
	
	if($i == 10) {
		return true;
	}
}

function inicializarSessoes() {

	if(!array_key_exists('totalC',$_SESSION)) {
		$_SESSION['totalC'] = '';
	}
	
	if(!array_key_exists('totalL',$_SESSION)) {
		$_SESSION['totalL'] = '';
	}
	
	if(!array_key_exists('totalD',$_SESSION)) {
		$_SESSION['totalD'] = '';
	}
}

