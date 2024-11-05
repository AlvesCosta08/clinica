<?php 

require_once("../../../conexao.php");

$tabela = 'pagar';

@session_start();

$id_usuario = $_SESSION['id'];



$dataInicial = @$_POST['data_inicial'];

$dataFinal = @$_POST['data_final'];

$funcionario = @$_POST['id_funcionario'];



if ($funcionario == '') {

    $funcionario = 0;

}


$pdo->query("UPDATE pagar SET pago = 'Sim', usuario_pgto = '$id_usuario', data_pgto = curDate() where data_lanc >= '$dataInicial' and data_lanc <= '$dataFinal' and pago != 'Sim' and funcionario = '$funcionario' and referencia like '%Comissao%'");



echo 'Baixado com Sucesso';

 ?>