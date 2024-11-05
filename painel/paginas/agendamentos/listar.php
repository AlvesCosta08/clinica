<?php 

require_once("../../../conexao.php");

@session_start();

$usuario = @$_SESSION['id'];



$funcionario = @$_POST['funcionario'];

$data = @$_POST['data'];

$tabela = @$_POST['tabela'];





if($data == ""){

	$data = date('Y-m-d');

}



if($funcionario == ""){

	$sql_funcionario = "";

}else{

    $sql_funcionario = "funcionario = '$funcionario' and ";

}





if ($tabela == 'card') {

	$esconder_tabela = 'ocultar';

	$esconder_card = '';

}else{

	$esconder_tabela = '';

	$esconder_card = 'ocultar';

}	





$pdo->query("UPDATE agendamentos SET status_cor = 'Em espera' WHERE status_cor = 'Aguardando Confirmação' and status = 'Confirmado'");



$pdo->query("UPDATE agendamentos SET status_cor = 'Finalizado' WHERE status_cor != 'Finalizado' and status = 'Finalizado'");



if ($tabela != 'horarios') {

echo <<<HTML

<small>

HTML;

$query = $pdo->query("SELECT * FROM agendamentos where $sql_funcionario data = '$data' ORDER BY hora asc");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if($total_reg > 0){

	echo <<<HTML

<small>

	<table class="table table-hover {$esconder_tabela}" id="tabela">

	<thead> 

	<tr>

	<th>Hora</th>

	<th>Paciente</th>	

	

	<th>Procedimento</th>

	<th>Status</th>		

	

	<th>Ações</th>

	</tr> 

	</thead> 

	<tbody>	

HTML;

for($i=0; $i < $total_reg; $i++){

	foreach ($res[$i] as $key => $value){}

$id = $res[$i]['id'];

$funcionario = $res[$i]['funcionario'];

$cliente = $res[$i]['paciente'];

$hora = $res[$i]['hora'];

$data = $res[$i]['data'];

$usuario = $res[$i]['usuario'];

$data_lanc = $res[$i]['data_lanc'];

$obs = $res[$i]['obs'];

$status = $res[$i]['status'];

$servico = $res[$i]['servico'];

$pago = $res[$i]['pago'];

$st = $res[$i]['status_cor'];

$tipo_pagamento = $res[$i]['tipo_pagamento'];

$retorno = $res[$i]['retorno'];



$novo_status = $res[$i]['status_cor'];



$dataF = implode('/', array_reverse(explode('-', $data)));

$horaF = date("H:i", strtotime($hora));





if($status == 'Concluído'){		

	$classe_linha = '';

}else{		

	$classe_linha = 'text-muted';

}



$ocultar_confirmacao = '';



if($status == 'Agendado'){

	$imagem = 'icone-relogio.png';

	$classe_status = '';	

}else if($status == 'Finalizado'){

	$imagem = 'icone-relogio-verde.png';

	$classe_status = 'ocultar';

	$ocultar_confirmacao = 'ocultar';

}if($status == 'Confirmado'){

	$imagem = 'icone-relogio-azul.png';

	$classe_status = 'ocultar';

	$ocultar_confirmacao = 'ocultar';

}



if($tipo_pagamento != ''){

	$classe_pago = 'icone-money.png';

	$ocultar_pago = 'ocultar';

}else{

	$classe_pago = 'icone-money-red.png';

	$ocultar_pago = '';

}



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu = $res2[0]['nome'];

}else{

	$nome_usu = 'Sem Usuário';

}





$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_serv = $res2[0]['nome'];

	$valor_serv = $res2[0]['valor'];

	$aceita_convenio = $res2[0]['convenio'];

}else{

	$nome_serv = 'Não Lançado';

	$valor_serv = '';

	$aceita_convenio = @$res2[0]['convenio'];

}





$query2 = $pdo->query("SELECT * FROM pacientes where id = '$cliente'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_cliente = $res2[0]['nome'];

	$telefone_pac = $res2[0]['telefone'];

	

}else{

	$nome_cliente = 'Sem Paciente';

	

}



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_func = $res2[0]['nome'];

	

}else{

	$nome_func = '';

	

}

$tel_whatsF = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_pac);

 $nome_func = mb_strimwidth($nome_func, 0, 25, "...");





//retirar aspas do texto do obs

$obs = str_replace('"', "**", $obs);



echo <<<HTML

			<div class="col-xs-12 col-md-4 widget cardTarefas {$esconder_card}">

        		<div class="r3_counter_box">



				<li class="dropdown head-dpdn2" style="list-style-type: none;">

				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

		<button type="button" class="close" title="Excluir agendamento" style="margin-top: -10px">

					<span aria-hidden="true"><big>&times;</big></span>

				</button>

				</a>



		<ul class="dropdown-menu" style="margin-left:-30px;">

		<li>

		<div class="notification_desc2">

		<p>Confirmar Exclusão? <a href="#" onclick="excluirAgendamento('{$id}', '{$horaF}')"><span class="text-danger">Sim</span></a></p>

		</div>

		</li>										

		</ul>

		</li>





		<div class="row">

        		<div class="col-md-3">





				<li class="dropdown head-dpdn2" style="list-style-type: none;">

				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

		<img class="icon-rounded-vermelho" src="img/{$imagem}" width="45px" height="45px">

				</a>



		<ul class="dropdown-menu" style="margin-left:-30px;">

		<li>

		<div class="notification_desc2">

		<p>Observações: {$obs}</p>

		</div>

		</li>										

		</ul>

		</li>

        			 

        		</div>

        		<div class="col-md-9">

        			<h5><strong>{$horaF}</strong> 



        			<li class="dropdown head-dpdn2" style="list-style-type: none; display:inline-block;">

				<a class="{$ocultar_confirmacao}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

		<img class="icon-rounded-vermelho" src="img/check-square.png" width="15px" height="15px">

				</a>



		<ul class="dropdown-menu" style="margin-left:-100px;">

		<li>

		<div class="notification_desc2">

		<p>Confirmar Agendamento? <a title="Confirmar Agendamento" href="#" onclick="confirmar('{$id}', '{$horaF}')"><span class="text-success">Sim</span></a></p>

		</div>

		</li>										

		</ul>

		</li>





        	



        			<a class="{$ocultar_pago}" href="#" onclick="baixar('{$id}', '{$cliente}', '{$nome_serv}', '{$valor_serv}','{$aceita_convenio}','{$funcionario}','{$servico}','{$retorno}')" title="Baixa no Pagamento" class=""> <img class="icon-rounded-vermelho" src="img/{$classe_pago}" width="15px" height="15px"></a>



        			<a class="" href="#" onclick="editar('{$id}','{$cliente}','{$funcionario}','{$servico}','{$data}','{$obs}','{$retorno}')" title="Editar Agendamento" class=""> <img class="icon-rounded-vermelho" src="img/editar.png" width="15px" height="15px"></a>



        			<a class="" href="rel/atendimento_class.php?id={$id}" title="Relatório de Atendimento" target="_blank"><img class="icon-rounded-vermelho" src="img/pdf.png" width="15px" height="15px"></a>



        			</h5>



        			

        		</div>





        		</div>

        		

        					

        		<hr style="margin-top:-2px; margin-bottom: 3px">                    

                    <div class="stats esc" align="center">

                      <span>

                      

                        <small> {$nome_cliente}<br> (<i><span style="color:#061f9c; font-size: 12px">{$nome_serv}</span></i>)</small></span>

                    </div>

                </div>

        	</div>

HTML;

if ($st == '' and $status == 'Confirmado') {

	$st = 'Aguardando Paciente';

}else if ($st == ''){

	$st = 'Aguardando Confirmação';

}





if ($status == 'Confirmado') {

	$amarelo = 'text-primary';

	$nao_exibir = '';



}else{

	$amarelo = '';

	$nao_exibir = 'ocultar';

}

$status_atual = 'Aguardando Paciente';





if ($st == 'Em espera') {

	$amarelo = 'em-espera';

}else if ($st == 'Em atendimento') {

	$amarelo = 'em-atendimento';

}else if ($st == 'Prioridade') {

	$amarelo = 'Prioridade';

}







echo <<<HTML

<tr>



<td class="esc">{$hora}</td>

<td class="{$amarelo}" id="campoDestino">

{$nome_cliente}

</td>







<td class="esc">{$nome_serv} <span class="text-primary"><small>({$nome_func})</small></span></td>

<td class="" >

<li class="dropdown head-dpdn2  " style="list-style-type: none; display:inline-block;">

				<a  href="#" class="{$nao_exibir}" data-toggle="dropdown" aria-expanded="false">

		<img class="icon-rounded-vermelho" src="img/editar.png" width="15px" height="15px">

				</a>



		<ul class="dropdown-menu" style="margin-left:-100px;">

		<li>

		<div class="notification_desc2">

		<p><big><b>Alterar Status:</b></big> <br><a title="Em espera" href="#" onclick="alterarCorCelaDestino('#d1a773', 'Em espera', {$id})"><span class="text-success" style="color:#2a2b29">Em espera</span></a><br>

		<a title="Em atendimento" href="#" onclick="alterarCorCelaDestino('#a4db84', 'Em atendimento', {$id})"><span class="text-success" style="color:##2a2b29">Em atendimento</span></a><br>

		<a title="Prioridade" href="#" onclick="alterarCorCelaDestino('#b0c5f5', 'Prioridade', {$id})"><span class="text-success" style="color:##2a2b29">Prioridade</span></a></p>

		</div>

		</li>										

		</ul>

		</li>

{$novo_status}

		





</td>







<td>

<big><a class="" href="http://api.whatsapp.com/send?1=pt_BR&phone={$tel_whatsF}" title="Whatsapp" target="_blank"><i class="fa fa-whatsapp " style="color:green"></i></a></big>



	<big><a class="" href="#" onclick="editar('{$id}','{$cliente}','{$funcionario}','{$servico}','{$data}','{$obs}','{$retorno}')" title="Editar Agendamento" class=""> <img class="icon-rounded-vermelho" src="img/editar.png" width="15px" height="15px"></a>

</big>



<big><a class="{$ocultar_pago}" href="#" onclick="baixar('{$id}', '{$cliente}', '{$nome_serv}', '{$valor_serv}','{$aceita_convenio}','{$funcionario}','{$servico}','{$retorno}')" title="Baixa no Pagamento" class=""> <img class="icon-rounded-vermelho" src="img/{$classe_pago}" width="15px" height="15px"></a></big>



	<li class="dropdown head-dpdn2" style="list-style-type: none; display:inline-block;">

				<a class="{$ocultar_confirmacao}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

		<img class="icon-rounded-vermelho" src="img/check-square.png" width="15px" height="15px">

				</a>



		<ul class="dropdown-menu" style="margin-left:-200px;">

		<li>

		<div class="notification_desc2">

		<p>Confirmar Agendamento? <a title="Confirmar Agendamento" href="#" onclick="confirmar('{$id}', '{$horaF}')"><span class="text-success">Sim</span></a></p>

		</div>

		</li>										

		</ul>

		</li>



		<li class="dropdown head-dpdn2" style="display: inline-block;">

		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>



		<ul class="dropdown-menu" style="margin-left:-230px;">

		<li>

		<div class="notification_desc2">

		<p>Confirmar Exclusão? <a href="#" onclick="excluirAgendamento('{$id}', '{$horaF}')"><span class="text-danger">Sim</span></a></p>

		</div>

		</li>										

		</ul>

</li>




<big><a class="" href="rel/atendimento_class.php?id={$id}" title="Relatório de Atendimento" target="_blank"><i class="fa fa-file-pdf-o " style="color:blue"></i></a></big>



</td>

</tr>

HTML;

}



}else{

	echo 'Nenhum horário para essa Data!';

}


}else{
	//aqui vai a opcao dos horarios
	echo '<div id="listar_horarios_disp"></div>';
}


?>











<script type="text/javascript">

	function baixar(id, cliente, servico, valor_servico, convenio, funcionario, id_servico, retorno){



		if(convenio != "Sim"){

			$('#div_convenio').hide();

		}



		$('#procedimento').text("Procedimento");



		if(retorno == "Sim"){

			$('#valor_serv_agd').val("0");

			$('#procedimento').text("Retorno");

		}else{

			$('#valor_serv_agd').val(valor_servico);

		}





	

		$('#id_agd').val(id);

		$('#cliente_agd').val(cliente);		

		$('#servico_agd').val(id_servico);	

			

		$('#funcionario_agd').val(funcionario).change();	

		$('#titulo_servico').text(servico);

		$('#descricao_serv_agd').text(servico);

		$('#modalServico').modal('show');

	}



	function confirmar(id){

		 $.ajax({

        url: 'paginas/' + pag + "/confirmar.php",

        method: 'POST',

        data: {id},

        dataType: "html",



        success:function(mensagem){

             

            if (mensagem.trim() == "Confirmado com Sucesso") {  



                listar();

            } else {

                $('#mensagem-excluir').addClass('text-danger')

                $('#mensagem-excluir').text(mensagem)

            }

        }

    });

	}





	function editar(id, paciente, funcionario, servico, data, obs, retorno){

		$('#mensagem').text('');

    	$('#titulo_inserir').text('Editar Registro');



    	if(retorno == ""){

    		retorno = 'Não';

    	}



    	$('#id').val(id);

    	$('#cliente').val(paciente).change();

    	

    	$('#funcionario_modal').val(funcionario).change();

    	$('#data-modal').val(data).change();

    	$('#obs').val(obs);

    	$('#retorno').val(retorno).change();	



    	setTimeout(function(){

			$('#servico').val(servico).change();	   

		}, 500); 

    	

    

    	$('#modalForm').modal('show');

	}





function excluirAgendamento(id){	

    $('#mensagem-excluir').text('Excluindo...')

    

    $.ajax({

        url: 'paginas/' + pag + "/excluir.php",

        method: 'POST',

        data: {id},

        dataType: "html",



        success:function(mensagem){

             //alert(mensagem)

            if (mensagem.trim() == "Excluído com Sucesso") {  



                listar();

                listarHorarios();

            } else {

                $('#mensagem-excluir').addClass('text-danger')

                $('#mensagem-excluir').text(mensagem)

            }

        }

    });

}

</script>





<script type="text/javascript">

function alterarCorCelaDestino(cor, status, id) {



    var campoDestino = document.getElementById('campoDestino');



    campoDestino.style.backgroundColor = cor;

     campoDestino.classList.remove('amarelo');





     $.ajax({

        url: 'paginas/' + pag + "/alterar_stat.php",

        method: 'POST',

        data: {cor,status,id},

        dataType: "html",



        success:function(mensagem){

             //alert(mensagem)

            if (mensagem.trim() == "Alterado com Sucesso") {  



                listar();

                listarHorarios();

            } else {

                $('#mensagem-excluir').addClass('text-danger')

                $('#mensagem-excluir').text(mensagem)

            }

        }

    });

}





   





</script>



<script type="text/javascript">

function alterarCorCelaDestino2(cor) {

    var campoDestino = document.getElementById('campoDestino');

    campoDestino.style.backgroundColor = cor;

     campoDestino.classList.remove('amarelo');

}	





</script>



<script type="text/javascript">

function alterarCorCelaDestino3(cor) {

    var campoDestino = document.getElementById('campoDestino');

    campoDestino.style.backgroundColor = cor;

     campoDestino.classList.remove('amarelo');





}	





</script>