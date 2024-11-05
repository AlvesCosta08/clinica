<?php 

require_once("verificar.php");

require_once("../conexao.php");

$pag = 'agendamentos';

$data_atual = date('Y-m-d');





//verificar se ele tem a permissão de estar nessa página

if(@$agendamentos == 'ocultar'){

	echo "<script>window.location='../index.php'</script>";

	exit();

}



?>



<div class="row">

	<div class="col-md-4">

		<button style="margin-bottom:10px" onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Agendamento</button>

	</div>



	<?php 

				if($atendimento_usuario == 'Sim' and $nivel_usuario != 'Administrador'){

					$id_func = $id_usuario;

					$ocultar_select = 'ocultar';

				}else{

					$id_func = '';

					$ocultar_select = '';

				}

			?>

	<div class="col-md-3 <?php echo $ocultar_select ?>">

		<div class="form-group">			

			<select class="form-control sel200" id="funcionario" name="funcionario" style="width:100%;" onchange="mudarFuncionario()"> 

				<?php if($id_func == ""){ ?>

				<option value="">Selecione um Profissional</option>

							

				<?php 

				$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY id desc");

				$res = $query->fetchAll(PDO::FETCH_ASSOC);

				$total_reg = @count($res);

				if($total_reg > 0){

					for($i=0; $i < $total_reg; $i++){

						foreach ($res[$i] as $key => $value){}

							echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';

					}

				}



				}else{

									echo '<option value="'.$id_usuario.'">'.$nome_usuario.'</option>';

									}

				?>





			</select> 





		</div> 	

	</div>





	<div class="col-md-3 ">

		<div class="form-group">			

			<select class="sel200" id="table" name="table" style="width:100%; " onchange="listar()"> 

				

				<option value="tabela">Mostrar Tabela</option>

				<option value="card">Mostrar Card</option>			

				<option value="horarios">Horários Disponíveis</option>	



			</select> 



			  

		</div> 	

	</div>



</div>

<input type="hidden" name="data_agenda" id="data_agenda" value="<?php echo date('Y-m-d') ?>"> 



<div class="row" style="margin-top: 15px">



	<div class="col-md-4 agile-calendar">

		<div class="calendar-widget">



			<!-- grids -->

			<div class="agile-calendar-grid">

				<div class="page">



					<div class="w3l-calendar-left">

						<div class="calendar-heading">



						</div>

						<div class="monthly" id="mycalendar"></div>

					</div>



					<div class="clearfix"> </div>

				</div>

			</div>

		</div>

	</div>





	<div class="col-xs-12 col-md-8 bs-example widget-shadow" style="padding:10px 5px; margin-top: 0px;" id="listar">



	</div>

</div>













<!-- Modal -->

<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">

	<div class="modal-dialog modal-lg" role="document">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title" id="titulo_inserir"></h4>

				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">

					<span aria-hidden="true">&times;</span>

				</button>

			</div>

			<form method="post" id="form-text">

				<div class="modal-body">



					<div class="row">

						<div class="col-md-4">						

							<div class="form-group"> 

								<label>Paciente</label> 
								<div id="listar_pacientes"></div>								

							</div>		

								
						</div>	


						<div class="col-md-1" style="margin-top: 22px; margin-left: -10px">
							<button id="btn_cliente" type="button" data-toggle="modal" data-target="#modalPacientes" class="btn btn-primary"> <i class="fa fa-plus"></i> </button>		

						</div>





						<div class="col-md-4 ">

							<div class="form-group">

							<label>Profissional </label> 			

								<select class="form-control sel2" id="funcionario_modal" name="funcionario" style="width:100%;" onchange="mudarFuncionarioModal()"> 

									<?php if($id_func == ""){ ?>

									<option value="">Selecione um Profissional</option>

									<?php 

									$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY id desc");

									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									$total_reg = @count($res);

									if($total_reg > 0){

										for($i=0; $i < $total_reg; $i++){

											foreach ($res[$i] as $key => $value){}

												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';

										}

									}



								}else{

									echo '<option value="'.$id_usuario.'">'.$nome_usuario.'</option>';

									}



									?>

								





								</select>   

							</div> 	

						</div>



						<div class="col-md-3">						

							<div class="form-group"> 

								<label>Procedimento</label> 

								<select class="form-control sel3" id="servico" name="servico" style="width:100%;" required> 									



								</select>    

							</div>						

						</div>



					</div>

					<div class="row">						



						<div class="col-md-3" id="nasc">						

							<div class="form-group"> 

								<label>Data </label> 

								<input type="date" class="form-control" name="data" id="data-modal" onchange="mudarData()"> 

							</div>						

						</div>



					<div class="col-md-7">						

						<div class="form-group"> 

							<label>OBS <small>(Máx 100 Caracteres)</small></label> 

							<input maxlength="100" type="text" class="form-control" name="obs" id="obs">

						</div>						

					</div>



					<div class="col-md-2 ">

							<div class="form-group">

							<label>Retorno</label> 			

								<select class="form-control" id="retorno" name="retorno"  >

									<option value="Não">Não</option>

									<option value="Sim">Sim</option>

								</select>   

							</div> 	

						</div>





					</div>





					<hr>

					<div class="row">



						<div class="col-md-12" id="nasc">						

							<div class="form-group"> 								

								<div id="listar-horarios">

									<small>Selecione um Profissional ou um Procedimento</small>

								</div>

							</div>						

						</div>					



					</div>

					<hr>







				







					<br>

					<input type="hidden" name="id" id="id">

					<input type="hidden" name="id_funcionario" id="id_funcionario" value="<?php echo $id_func ?>"> 

					<small><div id="mensagem" align="center" class="mt-3"></div></small>					



				</div>





				<div class="modal-footer">

					<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>

				</div>







			</form>



		</div>

	</div>

</div>















<!-- Modal -->

<div class="modal fade" id="modalServico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"><span id="procedimento"></span> <span id="titulo_servico"></span></h4>

				<button id="btn-fechar-servico" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">

					<span aria-hidden="true">&times;</span>

				</button>

			</div>

			<form method="post" id="form-servico">

				<div class="modal-body">



					<div class="row">

						<div class="col-md-5">						

							<div class="form-group"> 

								<label>Funcionário</label> 

								<select class="form-control sel4" id="funcionario_agd" name="funcionario_agd" style="width:100%;" required> 



									<?php 

									$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY nome asc");

									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									$total_reg = @count($res);

									if($total_reg > 0){

										for($i=0; $i < $total_reg; $i++){

											foreach ($res[$i] as $key => $value){}

												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';

										}

									}

									?>





								</select>    

							</div>						

						</div>





						<div class="col-md-3" id="nasc">						

							<div class="form-group"> 

								<label>Valor </label> 

								<input type="text" class="form-control" name="valor_serv_agd" id="valor_serv_agd"> 

							</div>						

						</div>





						<div class="col-md-4" id="nasc">						

							<div class="form-group"> 

								<label>Data PGTO</label> 

								<input type="date" class="form-control" name="data_pgto" id="data_pgto" value="<?php echo $data_atual ?>"> 

							</div>						

						</div>	





					</div>



					<div class="row">



						<div class="col-md-4">						

							<div class="form-group"> 

								<label>Forma PGTO</label> 

								<select class="form-control" id="pgto" name="pgto" style="width:100%;"> 

									<option value="Convênio">Convênio</option>



									<?php 

									$query = $pdo->query("SELECT * FROM formas_pgto");

									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									$total_reg = @count($res);

									if($total_reg > 0){

										for($i=0; $i < $total_reg; $i++){

											foreach ($res[$i] as $key => $value){}

												echo '<option value="'.$res[$i]['nome'].'">'.$res[$i]['nome'].'</option>';

										}

									}

									?>





								</select>    

							</div>						

						</div>



						<div class="col-md-8" id="div_convenio">						

							<div class="form-group"> 

								<label>Convênio </label> 

								<select class="form-control" id="convenio" name="convenio" style="width:100%;" onchange="calcularValor()">



								<option value="">Selecione um Convênio</option> 



									<?php 

									$query = $pdo->query("SELECT * FROM convenios");

									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									$total_reg = @count($res);

									if($total_reg > 0){

										for($i=0; $i < $total_reg; $i++){

											foreach ($res[$i] as $key => $value){}

												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';

										}

									}

									?>





								</select>  

							</div>						

						</div>



					</div>


					<div class="row">
						<div class="col-md-12">
							<div class="form-group"> 

								<label>Número do Convênio</label> 

								<input type="text" class="form-control" name="numero_convenio" id="numero_convenio" placeholder="Número do convênio"> 

							</div>		
						</div>
					</div>




					<br>

					

					<input type="hidden" name="id_agd" id="id_agd"> 

					<input type="hidden" name="cliente_agd" id="cliente_agd"> 

					<input type="hidden" name="servico_agd" id="servico_agd">

					<input type="hidden" name="descricao_serv_agd" id="descricao_serv_agd">

					

					<small><div id="mensagem-servico" align="center" class="mt-3"></div></small>					



				</div>





				<div class="modal-footer">

					<button id="btn_salvar_servico" type="submit" class="btn btn-primary">Salvar</button>

				</div>







			</form>



		</div>

	</div>

</div>









<!-- Modal Pacientes -->

<div class="modal fade" id="modalPacientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title" id="exampleModalLabel">Novo Paciente</h4>

				<button id="btn-fechar-pacientes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">

					<span aria-hidden="true">&times;</span>

				</button>

			</div>

			<form id="form-pacientes">

				<div class="modal-body">





					<div class="row">

						<div class="col-md-3">							

							<label>Nome</label>

							<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							

						</div>





						<div class="col-md-3">							

							<label>CPF</label>

							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" >							

						</div>



						<div class="col-md-3">							

							<label>Telefone</label>

							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" required>							

						</div>





						<div class="col-md-3">							

							<label>Data Nascimento</label>

							<input type="date" class="form-control" id="data_nasc" name="data_nasc" required>							

						</div>



						

					</div>





					<div class="row">	

								

										

							<div class="col-md-5">	

									<label>Profissão</label>

									<input type="text" class="form-control" name="profissao" id="profissao">

								</div>



						





							<div class="col-md-2">	

								<label>Sexo</label>

								<select class="form-control" name="sexo" id="sexo">

									<option value="M">M</option>

									<option value="F">F</option>

									

								</select>						

							</div>



							



							<div class="col-md-2">	

								<label>Tipo Sanguíneo</label>

								<select class="form-control" name="tipo_sanguineo" id="tipo_sanguineo">

									<option value="O">O</option>

									<option value="A">A</option>

									<option value="B">B</option>

									<option value="AB">AB</option>

								</select>						

							</div>





							<div class="col-md-3">	

								<label>Convênio</label>

								<select class="form-control" name="convenio" id="convenio">

									<option value="0">Nenhum</option>

									<?php 

									$query = $pdo->query("SELECT * from convenios order by id asc");

									$res = $query->fetchAll(PDO::FETCH_ASSOC);

									$linhas = @count($res);

									if($linhas > 0){

										for($i=0; $i<$linhas; $i++){

											?>

											<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>



										<?php } } ?>

									</select>	



								</div>						

							</div>



							<div class="row">



									<div class="col-md-8">	





								<label>Endereço</label>

								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Seu Endereço" >							

							</div>	



							<div class="col-md-4">	

								<label>Estado Cívil</label>

								<select class="form-control" name="estado_civil" id="estado_civil">

									<option value="Solteiro">Solteiro(a)</option>

									<option value="Casado">Casado(a)</option>

									<option value="Víuvo">Víuvo(a)</option>

									<option value="Divorciado">Divorciado(a)</option>

								</select>						

							</div>	



							

								

							</div>





							<div class="row">

								<div class="col-md-12">	

									<label>Observações</label>

									<input type="text" class="form-control" name="obs" id="obs_pac">

								</div>

							</div>



							<hr>



							<div class="row">

						<div class="col-md-5">							

							<label>Nome Responsável</label>

							<input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" placeholder="Seu Nome">							

						</div>





						<div class="col-md-3">							

							<label>CPF Responsável</label>

							<input type="text" class="form-control" id="cpf_responsavel" name="cpf_responsavel" placeholder="CPF Responsável">							

						</div>					

						

					</div>

								



						<br>

						<small><div id="mensagem_pacientes" align="center"></div></small>

					</div>

					<div class="modal-footer">       

						<button id="btn_salvar_pacientes" type="submit" class="btn btn-primary">Salvar</button>

					</div>

				</form>

			</div>

		</div>

	</div>











<script type="text/javascript">var pag = "<?=$pag?>"</script>

<script src="js/ajax.js"></script>





<!-- calendar -->

<script type="text/javascript" src="js/monthly.js"></script>

<script type="text/javascript">

	$(window).load( function() {



		$('#mycalendar').monthly({

			mode: 'event',



		});



		$('#mycalendar2').monthly({

			mode: 'picker',

			target: '#mytarget',

			setWidth: '250px',

			startHidden: true,

			showTrigger: '#mytarget',

			stylePast: true,

			disablePast: true

		});



		switch(window.location.protocol) {

			case 'http:':

			case 'https:':

		// running on a server, should be good.

		break;

		case 'file:':

		alert('Just a heads-up, events will not work when run locally.');

	}



});

</script>

<!-- //calendar -->



<script type="text/javascript">

	$(document).ready(function() {

		listarPacientes()

		var atend = "<?=$atendimento_usuario?>";



		if(atend == 'Sim'){

			$('#funcionario').val("<?=$id_usuario?>").change();

		}

		



		mudarFuncionarioModal()

		

		$('.sel3').select2({

			dropdownParent: $('#modalForm')

		});

		$('.sel200').select2({

			//dropdownParent: $('#modalForm')

		});

	});

</script>





<script type="text/javascript">

	$(document).ready(function() {

		$('.sel2').select2({

			

		});

	});

</script>





<script type="text/javascript">

	$(document).ready(function() {

		

		$('.sel4').select2({

			dropdownParent: $('#modalServico')

		});

	});

</script>







<script>



	$("#form-text").submit(function () {

		$('#mensagem').text('Carregando...');

		$('#btn_salvar').hide();

		event.preventDefault();

		

		var formData = new FormData(this);



		$.ajax({

			url: 'paginas/' + pag +  "/inserir.php",

			type: 'POST',

			data: formData,



			success: function (mensagem) {

				

				$('#mensagem').text('');

				$('#mensagem').removeClass()

				if (mensagem.trim() == "Salvo com Sucesso") {                    

					$('#btn-fechar').click();

					listar();

					listarHorarios();

				} else {

					$('#mensagem').addClass('text-danger')

					$('#mensagem').text(mensagem)

				}



				$('#btn_salvar').show();



			},



			cache: false,

			contentType: false,

			processData: false,



		});



	});



</script>









<script type="text/javascript">

	function listar(){



		var funcionario = $('#funcionario_modal').val();

		var tabela = $("#table").val();	
	

		var data = $("#data_agenda").val();	

		$("#data-modal").val(data);





		$.ajax({

			url: 'paginas/' + pag + "/listar.php",

			method: 'POST',

			data: {data, funcionario, tabela},

			dataType: "text",



			success:function(result){

				$("#listar").html(result);

			}

		});



		if(tabela != 'horarios'){
			return;
		}

		if(funcionario == ""){
			alert("Selecione um Funcionário");
			return;
		}

	setTimeout(() => {

		$.ajax({
        url: 'paginas/' + pag + "/listar_horarios_vagos.php",
        method: 'POST',
        data: {funcionario, data},
        dataType: "html",

        success:function(result){
        	//alert(result)
            $("#listar_horarios_disp").html(result);           
        }
    });
  
	}, "200");
	

	

	}

</script>









<script type="text/javascript">

	

	function limparCampos(){

		$('#id').val('');		

		$('#obs').val('');

		$('#hora').val('');				

		$('#data').val('<?=$data_atual?>');	



	}

</script>





<script type="text/javascript">

	

	function mudarFuncionario(){

		var funcionario = $('#funcionario').val();

		$('#id_funcionario').val(funcionario);	

		$('#funcionario_modal').val(funcionario).change();



		listar();	

		listarHorarios();

		listarServicos(funcionario);
		

	}

</script>











<script type="text/javascript">

	

	function mudarFuncionarioModal(){	

		var func = $('#funcionario_modal').val();	

		listar();	

		listarHorarios();

		listarServicos(func);

	}

</script>







<script type="text/javascript">

	

	function mudarData(){

		var data = $('#data-modal').val();			

		$('#data_agenda').val(data).change();



		listar();	

		listarHorarios();



	}

</script>







<script type="text/javascript">

	function listarHorarios(hora){
		var funcionario = $('#funcionario_modal').val();		
		var data = $('#data_agenda').val();	


		$.ajax({
			url: 'paginas/' + pag + "/listar-horarios.php",
			method: 'POST',
			data: {funcionario, data, hora},
			dataType: "html",

			success:function(result){
				
				$("#listar-horarios").html(result);

			}

		});

	}

</script>













<script>



	$("#form-servico").submit(function () {

		event.preventDefault();

		

		var formData = new FormData(this);



		var convenio = $('#convenio').val();

		var pgto = $('#pgto').val();



		if(pgto == "Convênio" && convenio == ""){

			alert("Selecione um Convênio ou uma forma de pagamento");

			return;

		}



		$.ajax({

			url: 'paginas/' + pag +  "/inserir-servico.php",

			type: 'POST',

			data: formData,



			success: function (mensagem) {

				$('#mensagem-servico').text('');

				$('#mensagem-servico').removeClass()

				if (mensagem.trim() == "Salvo com Sucesso") {                    

					$('#btn-fechar-servico').click();

					listar();

				} else {

					$('#mensagem-servico').addClass('text-danger')

					$('#mensagem-servico').text(mensagem)

				}



			},



			cache: false,

			contentType: false,

			processData: false,



		});



	});



</script>







<script type="text/javascript">

	function listarServicos(func){	

		var serv = $("#servico").val();

		

		$.ajax({

			url: 'paginas/' + pag +  "/listar-servicos.php",

			method: 'POST',

			data: {func},

			dataType: "text",



			success:function(result){

				$("#servico").html(result);

			}

		});

	}





	function calcularValor(){

		var convenio = $("#convenio").val();

		var id_agd = $("#id_agd").val();



		$.ajax({

			url: 'paginas/' + pag +  "/calcular.php",

			method: 'POST',

			data: {id_agd, convenio},

			dataType: "text",



			success:function(result){				

				$("#valor_serv_agd").val(result);

			}

		});

	}

</script>







<script>



	$("#form-pacientes").submit(function () {

		$('#mensagem_pacientes').text('Carregando...');

		$('#btn_salvar_pacientes').hide();

		event.preventDefault();

		

		var formData = new FormData(this);



		$.ajax({

			url: 'paginas/pacientes/salvar.php',

			type: 'POST',

			data: formData,



			success: function (mensagem) {
								

				$('#mensagem_pacientes').text('');

				$('#mensagem_pacientes').removeClass()

				if (mensagem.trim() == "Salvo com Sucesso") {                    

					$('#btn-fechar-pacientes').click();

					//listar();					
                	listarPacientes('1');

				} else {

					$('#mensagem_pacientes').addClass('text-danger')

					$('#mensagem_pacientes').text(mensagem)

				}



				$('#btn_salvar_pacientes').show();



			},



			cache: false,

			contentType: false,

			processData: false,



		});



	});



</script>


<script type="text/javascript">
	function listarPacientes(valor){
	$.ajax({
        url: 'paginas/' + pag + "/listar_pacientes.php",
        method: 'POST',
        data: {valor},
        dataType: "html",

        success:function(result){
            $("#listar_pacientes").html(result);           
        }
    });
}


function abrirModal(hora){
	listarHorarios(hora);
	inserir();
}
</script>


