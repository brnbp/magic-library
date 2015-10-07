<?php

require_once '../bootstrap.php';

$nome = addslashes($_GET['nome']);

$query = $conexao->query("SELECT * FROM produtos WHERE nome like '%{$nome}%' limit 1");

while($produtos = $query->fetch_assoc()){
	$jasao = 
	json_encode($produtos);
	//printr($jasao);
}
