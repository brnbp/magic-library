<?php

require_once '../app/system/Template.php';

$template = new Template(
    '../app/templates',
    'template_',
    '../magicPhalcon/'
);

function getIndex(){
    $var = explode('/',$_SERVER['SCRIPT_NAME']);
    if(count($var) == 4)
        return 'home';
    $file = $var[count($var)-1];
    unset($var);
    if($file == 'index.php')
        return 'index';
    else
        return 'submenu';
}


function printr($val){
	if (is_object($val) || is_array($val)) {
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	} elseif (empty($val) || is_resource($val)) {
		echo '<pre>';
		var_dump($val);
		echo '</pre>';
	} else
		echo $val;
}

function printrx($str){
	die(printr($str));
}

function vardump($string){
	echo '<pre>';
	var_dump($string);
	echo '</pre>';
}

function echobr($string)
{
	echo $string;
	echo '<br>';
}

function script($script)
{
	echo "<script>$script</script>";
}

function alert($string)
{
	$script = "alert('$string');";
	script($script);
}

function toValor($valor, $valor_parcial)
{
	$valor = str_replace(',', '.', str_replace('.', '', $valor));
	$valor_parcial += $valor;

	return $valor_parcial;
}


function normalize($string)
{	
	return ucwords(strtolower($string));
}

function formatDataTime($dateTime) {
    $explosao = explode(' ', $dateTime);
    $data = explode('-', $explosao[0]); // data
    $hora = explode(':', $explosao[1]); // hora

    return $data[2].'/'.$data[1].'/'.$data[0].' '.$hora[0].':'.$hora[1];
}

function formatData($date) {
    $explosao = explode(' ', $date);
    $data = explode('-', $explosao[0]); // data

    return $data[2].'/'.$data[1].'/'.$data[0];
}



function jsonToArray($json)
{		
    $object = (array) json_decode($json);
	$arr = array();	
	foreach($object as $key => $array){
		$arr[$key] = (array) $array;
	}
	return $arr;
}


$espaco = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$espaco0 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$espaco1 = $espaco0."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$espaco2 = $espaco1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$espaco3 = $espaco2."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";