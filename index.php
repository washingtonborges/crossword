<html>
<head>
    <title>Crossword</title>
</head>
<body>
<?php
//INICIA MATRIZ 
$matriz = "";

//ENCHER A MATRIZ COM - (traço)
for ($linha = 0; $linha < 10; $linha++) {
	for ($coluna = 0; $coluna < 15; $coluna++) {
		$matriz[$linha][$coluna] = " - ";
	}
}

//IMPRIMIR MATRIZ
for ($linha = 0; $linha < 10; $linha++) {
	for ($coluna = 0; $coluna < 15; $coluna++) {
		echo $linha."-".$coluna."|";
	}
	echo "<br>";
}
echo "<br><br><br><br>";

//PALAVRAS QUE SERÃO ENVIADAS PARA MATRIZ
$todaspalavras = array("BLUE","BLACK","RED","SCARLET");

//IMPRIMIR PALAVRAS
for ($a = 0; $a < count($todaspalavras); $a ++) {
	echo "Palavra ".$a." -> ".$todaspalavras[$a]."<br>";
}

//MONTAR A MATRIZ COM AS PALAVRAS
for ($i = 0; $i <  count($todaspalavras); $i++) {
	
	//MONTAR UM ARRAY COM CADA LETRA DA PALVRA
	$arrayLetra = pegaLetraPalavra($todaspalavras[$i]);
	
	//ENCONTRA LETRA DA PALVRA QUE É IGUAL NA MATRIZ 
	$arrayPosicao =encontrarSemelhante($arrayLetra,$matriz);
	
	//ENCONTRA MELHOR POSIÇÂO MONTAR A PALVRA (HORIZONTAL ou VERTICAL)
	$arrayResultado = verificaPosicao($arrayPosicao, $matriz);
	$linha = $arrayResultado[1];
	$coluna = $arrayResultado[2];
	
	//MONTA PALAVRA NA HORIZONTAL ou VERTICAL
	if ( $arrayResultado[0] == "H" ){
		//HORIZONTAL
		$matriz = montaHorizontal($todaspalavras[$i],$matriz,$linha,$coluna);
	}
	if ( $arrayResultado[0] == "V" ){
		//VERTICAL
		$matriz = montaVertical($todaspalavras[$i],$matriz,$linha,$coluna);
	}
	
	//IMPRIMIR A MATRIZ COM AS PALAVRAS
	for ($linha = 0; $linha < 10; $linha++) {
		for ($coluna = 0; $coluna < 15; $coluna++) {
			echo $matriz[$linha][$coluna];
		}
		echo "<br>";
	}
	echo "<br><br>";
}


function encontrarSemelhante($arrayLetra,$matriz){
	//BUSCAR LETRA igual na matriz INICIONADO SEMPRE DA POSIçÂO 0(ZERO) ou seja primeira letra
	$xxxx = buscaLetra($arrayLetra[0],$matriz);
	
	//xxxx -> RESULTADO DA PRIMEIRA BUSCA
	//array[0] ->linha
	$array[0] = $xxxx[0];
	
	//array[1] ->coluna
	$array[1] = $xxxx[1];
	
	//$array[2] ->posição da letra na palavra
	$array[2] = 0;
	
	//verifica -> descobre se encotrou ou não uma letra igual na matriz
	$verifica = $xxxx[2];
	
	//CASO NÂO ENCONTRAR LETRA IGUAL NA MATRIZ NA PRIMEIRA BUSCA 
	if ($verifica == 0){
		//TENTAR ENCONTRAR LETRA IGUAL PARA AS DE MAIS LETRAS DA PALVRA iniciando de 1(um) 
		for ($a = 1; $a < count($arrayLetra); $a ++) {
			//GAMBIARRA ;)
			//CONDICIONAL PARA SABER SE JÀ ENCONTROU LETRA NA MATRIZ
			//QUAL LOGICA? 
			//Resposta: se xxxx[0] estiver vazio ou seja não encontrou nenhuma letra semelhante na ultima execução do buscaLetra
			if ($xxxx[0] == ""){
				//SÒ SERÁ ExECUTADA CASO NÃO ENCONTRE NADA NA ULTIMA BUSCA
				//BUSCAR LETRA igual na matriz INICIONADO SEMPRE DA POSIçÂO 0(ZERO) ou seja primeira letra
				$xxxx = buscaLetra($arrayLetra[$a],$matriz);
			}
			
			//GAMBIARRA ;)
			//CONDICIONAL PARA SABER SE JÀ ENCONTROU LETRA NA MATRIZ
			//QUAL LOGICA? 
			//Resposta: se xxxx[2] estiver igual 1 ou seja encontrou letra semelhante na execução do buscaLetra
			//grava o resultado destro do array
			if ($xxxx[2] == 1 ){
				
				//array[0] ->linha
				$array[0] = $xxxx[0];
				
				//array[1] ->coluna
				$array[1] = $xxxx[1];
				
				//$array[2] ->posição da letra na palavra
				$array[2] = $a;
				
				//verifica -> descobre se encotrou ou não uma letra igual na matriz
				//NESTE CASO ENCONTROU - Valor será igual 1 (um)
				$verifica = $xxxx[2];
				
				////VARIAVEL PARA MANTER GAMBIARRA 100% :D
				/// ZERA A Variavel que mantem a gambiarra
				///para não entrar nesse if novamente. Aqui que está o problema: Sempre retorno a primeira solução encontrada.
				$xxxx[2] = 0;
			}
		}
	}
	
	//se leu todas as letras e não encontrou semelhante coloca a palavra nessa posição: linha =4 e coluna = 6
	if ($verifica == 0){
		//linha 
		$array[0] = 4;
		//coluna
		$array[1] = 6;
	}
	
	return $array;
}

function buscaLetra($letra,$matriz){
	$array[0] = "";
	$array[1] = "";
	$array[2] = 0;
	for ($linha = 0; $linha < 10; $linha++) {
		for ($coluna = 0; $coluna < 15; $coluna++) {
			if ($matriz[$linha][$coluna] == $letra){
				$array[0] = $linha;
				$array[1] = $coluna;
				$array[2] = 1;
			}
		}
	}
	return $array;	
}


function verificaPosicao($posicao, $matriz){
	$posicaoLetra = $posicao[2];
	$linhaAtual = $posicao[0];
	$colunaAtual = $posicao[1];
	$linhaAnterior = $posicao[0] - 1;
	$colunaAnterior = $posicao[1] - 1;
	$proximaLinha = $posicao[0] + 1;
	$proximaColuna = $posicao[1] + 1;
	if ($matriz[$proximaLinha][$colunaAtual] == " - " && $matriz[$linhaAnterior][$colunaAtual] == " - "){
		$array[0] = "V";
		$array[1] = $linhaAtual - $posicaoLetra;
		$array[2] = $colunaAtual;
	}
	if ($matriz[$linhaAtual][$proximaColuna] == " - "  && $matriz[$linhaAtual][$colunaAnterior] == " - "){
		$array[0] = "H";
		$array[1] = $linhaAtual;
		$array[2] = $colunaAtual - $posicaoLetra;
	}
	return $array;
}


function montaHorizontal($palavraHorizontal,$matrizHorizontal,$linhaAtual,$colunaAtual ){
	$arrayLetraPalavra = pegaLetraPalavra($palavraHorizontal);
	$tam =  count($arrayLetraPalavra);
	$maxColuna = $colunaAtual + $tam;
	$lastIndex = 0;
	for ($linha = 0; $linha < 10; $linha++) {
		for ($coluna = 0; $coluna < 15; $coluna++) {
				if ($linha == $linhaAtual && $coluna >= $colunaAtual && $coluna < $maxColuna){
					$matrizHorizontal[$linha][$coluna] = $arrayLetraPalavra[$lastIndex];
					$lastIndex = $lastIndex + 1;
					$colunaAtual = $colunaAtual + 1;
				}
		}
	}
	return $matrizHorizontal;
}

function montaVertical($palavraVertical,$matrizVertical,$linhaAtual,$linhaColuna ){
	$arrayLetraPalavra = pegaLetraPalavra($palavraVertical);
	$tam =  count($arrayLetraPalavra);
	$lastIndex = 0;
	for ($linha = 0; $linha < 10; $linha++) {
		for ($coluna = 0; $coluna < 15; $coluna++) {
				if ($coluna == $linhaColuna && $linha >= $linhaAtual ){
					$matrizVertical[$linha][$coluna] = $arrayLetraPalavra[$lastIndex];
					$lastIndex = $lastIndex + 1;
					$linhaAtual = $linhaAtual + 1;
				}
		}
	}
	return $matrizVertical;
}

function pegaLetraPalavra($palavra){
	$tam = strlen($palavra);
	for ($j = 0; $j < $tam; $j++) {
		$array[$j] = substr($palavra, $j,1);
	}
	return $array;
}
?>
</body>
</html>
