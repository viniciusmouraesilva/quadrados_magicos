<?php 
#quadrados mágicos
session_start();

const TOTAL_QUADRADOS = 16;

//indices de controle
$indice = 0; 
$coluna = 1;
// para criar a tabela: indice e coluna.

$ind_bcd = 0; //indice de b, c, d
$indice_letras_session = 1;
$indice_de_a = 1; //somente para letra a

//controle de erros
$erro_linha_coluna = false;
$erro = [];

if(!array_key_exists('gerou',$_SESSION)) {
/* letra  a */
for($i=0;$i<=3;$i++) {
	$_SESSION['a'][] = 0;
	$_SESSION['gerou'] = true;
}

/* letra b */
for($i=0;$i<=3;$i++) {
	$_SESSION['b'][] = 0;
}

/* letra c */
for($i=0;$i<=3;$i++) {
	$_SESSION['c'][] = 0;
}

/* letra d */
for($i=0;$i<=3;$i++) {
	$_SESSION['d'][] = 0;
}
}
/* colunas de controle */
$letras = array('a','b','c','d');

require 'helper.php';

inicializarSessoes();

print_r($_SESSION['totalC']);
print_r($_SESSION['totalL']);
print_r($_SESSION['totalD']);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if(array_key_exists('coluna',$_POST)) {
		$colunaT = (string)$_POST['coluna'];
		$resultadoC = verificarColuna($colunaT);
		
		$erro_linha_coluna = false;
		
		if($resultadoC == false) {
			$erro_linha_coluna = true;
			$erro['coluna'] = "Coluna inválida.";
		}
	}
	
	if(array_key_exists('linha',$_POST)) {
		$linhaT = (int)$_POST['linha'];
		if(!$erro_linha_coluna)
			$resultadoL = verificarLinha($linhaT);
		elseif(!$resultadoC)
			$erro['linha'] = "Linha inválida.";
	}
	
	if(array_key_exists('numero',$_POST)) {
		$numero = (int)$_POST['numero'];
	}
	
	if($resultadoC && $resultadoL)
		if($numero >= 1 && $numero <= 16) {
			
			switch($linhaT) {
				case 1:
					$linhaT = 0;
					break;
				case 2:
					$linhaT = 1;
					break;
				case 3:
					$linhaT = 2;
					break;
				case 4:
					$linhaT = 3;
					break;
			}
			
			$_SESSION["{$colunaT}"][$linhaT] = $numero;
			
			verificar_numero_digitado($numero , $colunaT , $linhaT);
			
		}else {
			$erro['numero'] = "Valor invlálido. Somente 1 a 16.";
		}
}

verificarVitoria();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Quadrados Mágicos</title>
	<style>
		/* tabela */
		.tabela {
			display; flex;
			flex-flow: row wrap;
			width: 60%;
			margin: 0 auto;
		}

		table {
			border: 1px solid black;
			border-collapse: collapse;
		}

		th, td {
			border: 1px solid black;
			padding: 20px;

		}

		/* formulário posicionamento */
		.form {
			margin-top: 10px;
			display: flex;
			flex-flow: row nowrap;
			width: 100%;
			justify-content: center;
		}

		.form option {
			font-size: 1.4em;
		}

		/* coluna e linha e butão*/
		.coluna {
			margin: 7px;
		}

		.linha {
			margin: 7px;
		}

		.numero {
			margin: 7px;
		}

		.button {
			background-color: white;
			border: 1px solid black;
		}

		h1, h2 {
			text-align: center;
		}
	</style>
</head>
<body>
	<h1>Quadrados Mágicos</h1>
	
	<?php if(array_key_exists('coluna',$erro)): ?>
		<?php echo $erro['coluna']; ?>
	<?php endif; ?>
	
	<?php if(array_key_exists('linha',$erro)): ?>
		<?php echo $erro['linha']; ?>
	<?php endif; ?>
	
	<?php if(array_key_exists('numero',$erro)): ?>
		<?php echo $erro['numero']; ?>
	<?php endif; ?>
	
	<!-- exibição da tabela -->
	<table class="tabela">
		<tr>
			<span class="vazio"><th></th></span>
			<th>A</th>
			<th>B</th>
			<th>C</th>
			<th>D</th>
		</tr>
		<?php for($i=0;$i<TOTAL_QUADRADOS;$i++): ?>	
			<?php echo ($i==0)?'<tr>':null; ?>	
			<?php if($indice < 4): ?>
					<?php if($indice == 0): ?>
							<!-- primeire linha 1 -->
							<td><?php print $coluna; ?></td>
							<!-- primeiro item A1 -->
							<td><?php print $_SESSION['a'][0]; ?></td>			
					<?php else: ?>
				
							<?php if($i > 1): ?>
								<?php $indice_letras_session++; ?>
							<?php endif; ?>
							
							<?php if($indice_letras_session >= 4): ?>
								<?php $indice_letras_session = 1; ?>
							<?php endif; ?>
							
							<?php $indice_letra = $letras[$indice_letras_session]; ?>
							
							<td><?php print $_SESSION["{$indice_letra}"][$ind_bcd]; ?></td>
					<?php endif; ?>
			<?php else: ?>
				<?php $ind_bcd++; ?>
				<?php $indice = 0; ?>				
				</tr>
				<tr>
					<?php $coluna++; ?>
					<?php print "<td>{$coluna}</td>"; ?><td><?php print $_SESSION['a'][$indice_de_a]; ?></td>
				<?php $indice_de_a++; ?>
			<?php endif; ?>
			<?php $indice++; ?>	
		<?php endfor; ?>
		</tr>
	</table>

	<!-- formulário para envio dos dados -->
	<form method="POST" class="form">
		<!-- coluna -->
		<select name="coluna" class="coluna">
			<option value="a">A</option>
			<option value="b">B</option>
			<option value="c">C</option>
			<option value="d">D</option>
		</select>

		<!-- linha -->
		<select name="linha" class="linha">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
		</select>

		<input type="number" name="numero" min=1 max=16 class="numero" value=0>
		<p><input type="submit" value="Enviar" class="button"></p>
	</form>
	
	<h2>Totais</h2>
	<table class="tabela">
		<tr>
			<th>A</th>
			<th>B</th>
			<th>C</th>
			<th>D</th>
		</tr>
		<tr>	
			<?php totalColuna(); ?>
		</tr>
	</table>
	<br>
	
	<table class="tabela">
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
		</tr>
		<tr>	
			<?php totalLinha(); ?>
		</tr>
	</table>
	
	<br>
	<table class="tabela">
		<tr>
			<th>A diagonal</th>
			<th>D diagonal</th>
		</tr>
		<tr>
			<?php totalDiagonalAD(); ?>
		</tr>
	</table>
</body>
</html>