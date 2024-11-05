<?php 

$tabela = 'receitas';

require_once("../../../conexao.php");



$nome = $_POST['nome'];

$quantidade = $_POST['quantidade'];

$uso = $_POST['uso'];

$id = $_POST['id'];



//validacao nome

$query = $pdo->query("SELECT * from $tabela where remedio = '$nome'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$id_reg = @$res[0]['id'];

if(@count($res) > 0 and $id != $id_reg){

	echo 'Nome Remédio já Cadastrado!';

	exit();

}





if($id == ""){

$query = $pdo->prepare("INSERT INTO $tabela SET remedio = :nome, quantidade = :quantidade, uso = :uso ");

	

}else{

$query = $pdo->prepare("UPDATE $tabela SET remedio = :nome, quantidade = :quantidade, uso = :uso where id = '$id'");

}

$query->bindValue(":nome", "$nome");

$query->bindValue(":quantidade", "$quantidade");

$query->bindValue(":uso", "$uso");

$query->execute();



echo 'Salvo com Sucesso';

 ?>