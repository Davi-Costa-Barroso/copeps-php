<?php 
$pag = 'coordenadores'; 

if(@$coordenadores == 'ocultar') {	
	echo '<script>window.location="../index.php"</script>';
	exit();
}

?> 

<style>
.modal-header {
    background-color: #033238; /* Cor de fundo preta */
    color: white; /* Cor do texto para ficar legível */
}
</style>
<style>
.modal-header .close {
    color: white; /* Cor branca para contrastar com o fundo preto */
    font-size: 1.5rem; /* Tamanho do ícone do X */
    opacity: 1; /* Deixa o botão completamente visível */
}
.modal-header .close:hover {
    color: #ddd; /* Cor mais clara ao passar o mouse */
}
</style>
 
	<!-- Botão Inserir novo Coordenador com a função "inserir()" via "ajax.js" -->
<a onclick="inserir()" title="Corpo Docente" type="button" class="btn btn-primary btn-dinamico"><span class="fa fa-plus"></span> Corpo Docente</a> 

  


<li class="dropdown head-dpdn2 btn-dinamico3" style="display: inline-block;">	
		<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-dinamico2" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li> 


<!-- Área que vai exibir a tabela com os dados do Coordenadores atraves datatables -->
<div class="bs-example widget-shadow" style="padding: 15px;" id="listar">

</div> 



<input type="hidden" id="ids">


 
 
<!-- Modal Form Coordenadores -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
        <button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-7">
              <label>Nome do Coordenador</label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome Completo" required>
            </div>
            <div class="col-md-5">
              <label>E-mail</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="E-mail">
            </div>
          </div>
          <div class="row mt-3"> <!-- Adicionando margem superior com mt-3 -->
            <div class="col-md-6">
              <label>Curso</label>
              <select class="form-control" id="curso" name="curso" required>
                <option value="">Selecione um curso</option>
                <option value="Engenharia Civil">Engenharia Civil</option>
                <option value="Engenharia Elétrica">Engenharia Elétrica</option>
                <option value="Engenharia de Computação">Engenharia de Computação</option>
                <option value="Engenharia Mecânica">Engenharia Mecânica</option>
                <option value="Engenharia Sanitária e Ambiental">Engenharia Sanitária e Ambiental</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Situação</label>
              <input type="text" class="form-control" id="situacao" name="situacao" placeholder="Situação" required>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-link btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Sair</button>
          <input type="hidden" class="form-control" id="id" name="id">
          <br>
          <small><div id="mensagem" align="center"></div></small>
        </div>
      </form>
    </div>
  </div>
</div>







<!-- Trás uma variavel do Php "$pag" que está la em cima pro javascript "var pag"  ele que vai ligar php com o javascript a variavel página -->
<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>



<script>
// Torna o modal arrastável quando ele for exibido
//precisa de - jquery-ui.js e 	
$(document).ready(function(){
    $("#modalForm").on("shown.bs.modal", function () {
        $(".modal-dialog").draggable({
            handle: ".modal-header", // Arrasta segurando a barra de título
            containment: "window"   // Mantém dentro da tela
        });
    });
});
</script>


