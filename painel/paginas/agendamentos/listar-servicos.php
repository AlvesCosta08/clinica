<?php 
require_once("../../../conexao.php");

$func = $_POST['func'];

$query = $pdo->query("SELECT * FROM func_proc where funcionario = '$func' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	for($i=0; $i < @count($res); $i++){
		$serv = $res[$i]['procedimento'];

		$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$serv' and ativo = 'Sim' ");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);	
		$nome_proc = $res2[0]['nome'];

		echo '<option value="'.$serv.'">'.$nome_proc.'</option>';
	}		
}else{
	echo '<option value="">Nenhum Serviço</option>';
}


?>

