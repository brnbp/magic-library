<?php

class Requisicao
{

	private $conexao;
	private $generos;
	private $categorias;

	public function Requisicao($conexao, $generos, $categorias)
	{
		$this->conexao = $conexao;
		$this->generos = $generos;
		$this->categorias = $categorias;
	}

	public function produtosAssocFilter($request)
	{
		return self::assocWhile($request);
	}


	public function produtosAssocAll()
	{
		$conexao = $this->conexao;
		$select_all = $conexao->query("SELECT * FROM produtos order by nome ASC");
		return self::assocWhile($select_all);
    }

	private function assocWhile($select)
	{
		$categorias = $this->categorias;
		$generos = $this->generos;

		$qtd_produtos = $select->num_rows;

	    while($ret = $select->fetch_assoc()){
	    	extract($ret);
	    	
	    	$id = $ret['id'];
	    	$produtos[$id]['nome'] = $nome;
	        $produtos[$id]['codigo'] =$codigo;
	        $produtos[$id]['vlr_custo'] =$vlr_custo;
	        $produtos[$id]['vlr_venda'] =$vlr_venda;
	    	$produtos[$id]['genero'] = array_search($genero, $generos);
	    	$produtos[$id]['categoria'] =  array_search($categoria, $categorias);
	    	$produtos[$id]['detalhes'] = $detalhes;
	    	$produtos[$id]['observacoes'] = $observacoes;
	    	$produtos[$id]['estoque_geral'] = $estoque_geral;
	    }

	    return $produtos;
	}



}