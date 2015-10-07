<?php

class Alert
{

public function getResultQuery($acao, $result, $place)
{
	self::chooseAlert($acao, $result, $place);
	if(($acao == 'encontra'  && ($place == 'clientes' || $place == 'produtos')) || ($place == 'index') )
		header("refresh:0; url=../index.php");
	else
		header("refresh:0; url=index.php");
}


private function chooseAlert($acao, $param, $place = null)
{

	if($acao == 'insert'){
		self::alertCadastro($param, $place);
	}elseif($acao == 'delete'){
		self::alertDeleta($param);
	}elseif($acao == 'atualiza'){
		self::alertAtualiza($param);
	}elseif($acao == 'encontra'){
		self::alertEncontra($param, $place);
	}

}

private function alertCadastro($param, $place=null)
{
	if($param == 1) {
        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
    } elseif($param == 0) {
        echo "<script>alert('Erro ao realizar cadastro!');</script>";
    } elseif($param == 2 && $place == 'clientes') {
        echo "<script>alert('Ja existe um registro com este cpf!');</script>";
    } elseif($param == 2 && $place =='produtos') {
        echo "<script>alert('Ja existe um registro com este codigo!');</script>";
    } elseif($param == 2 && $place == 'vendas') {
        echo '<script>alert("Cadastro realizado com sucesso! \\nNão esqueça de atualizar o estoque dos produtos vendidos!");</script>';
    }

}

private function alertDeleta($param)
{
	if($param == 1)
        echo "<script>alert('Registro deletado com sucesso!');</script>";
    elseif($param == 0)
        echo "<script>alert('Erro ao deletar registro!');</script>";
    elseif($param == 2)
        echo "<script>alert('Nao é possivel deletar registro com produtos associados ao mesmo!');</script>";

}

private function alertAtualiza($param)
{
	if($param == 1)
        echo "<script>alert('Registro atualizado com sucesso!');</script>";
    elseif($param == 0)
        echo "<script>alert('Erro ao atualizar registro!');</script>";
}

private function alertEncontra($param, $place)
{
	if($param == 0 && $place == 'clientes')
		echo "<script>alert('Nao existe cliente cadastrado com o cpf informado!');</script>";

	elseif($place == 'produtos')
			echo "<script>alert('Nao existe produtos com o filtro selecionado!');</script>";
}

}