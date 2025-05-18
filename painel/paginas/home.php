<?php
require_once("../conexao.php");
require_once("verificar.php");

if (@$home == 'ocultar') {	
    echo '<script>window.location="../index.php"</script>';
    exit();
}

$totalMembros = 0;
$totalUsuarios = 0;
$totalTarefasHoje = 0;
$totalTarefasConcluidasHoje = 0;
$porcentagemTarefas = 0;
$totalPareceresAno = 0;
$totalPareceresMes = 0;
$totalPareceresTodos = 0;
$totalPareceresAprovadosMes = 0;
$totalPareceresAprovadosAno = 0;
$totalPareceresAprovadosTodos = 0;
$totalPareceresNaoAprovadosMes = 0;
$totalPareceresNaoAprovadosAno = 0;
$totalPareceresNaoAprovadosTodos = 0;

// Buscar membros ativos
$query = $pdo->query("SELECT COUNT(*) as total FROM membros WHERE ativo = 'Sim'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalMembros = $res['total'] ?? 0;

// Buscar usuários ativos
$query = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE ativo = 'Sim'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalUsuarios = $res['total'] ?? 0;


// Buscar total de tarefas hoje
$query = $pdo->query("SELECT COUNT(*) as total FROM tarefas WHERE data = CURDATE() AND usuario = '$id_usuario'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalTarefasHoje = $res['total'] ?? 0;


// Buscar total de tarefas concluídas hoje
$query = $pdo->query("SELECT COUNT(*) as total FROM tarefas WHERE data = CURDATE() AND usuario = '$id_usuario' AND status = 'Concluída'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalTarefasConcluidasHoje = $res['total'] ?? 0;


// Calcular porcentagem de tarefas
if ($totalTarefasHoje > 0) {
    $porcentagemTarefas = ($totalTarefasConcluidasHoje / $totalTarefasHoje) * 100;
}



// Buscar total de pareceres no ano atual
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE ano = YEAR(CURDATE())");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresAno = $res['total'] ?? 0;

// Buscar total de pareceres no mês atual
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE YEAR(dataEnvio) = YEAR(CURDATE()) AND MONTH(dataEnvio) = MONTH(CURDATE())");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresMes = $res['total'] ?? 0;

// Buscar total de todos os pareceres
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresTodos = $res['total'] ?? 0;

// Buscar pareceres aprovados no mês atual
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE YEAR(dataEnvio) = YEAR(CURDATE()) AND MONTH(dataEnvio) = MONTH(CURDATE()) AND parecerRelator = 'aprovado'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresAprovadosMes = $res['total'] ?? 0;

// Buscar pareceres aprovados no ano atual
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE ano = YEAR(CURDATE()) AND parecerRelator = 'aprovado'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresAprovadosAno = $res['total'] ?? 0;

// Buscar total de todos os pareceres aprovados
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE parecerRelator = 'aprovado'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresAprovadosTodos = $res['total'] ?? 0;

// Buscar pareceres não aprovados no mês atual
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE YEAR(dataEnvio) = YEAR(CURDATE()) AND MONTH(dataEnvio) = MONTH(CURDATE()) AND parecerRelator = 'naoAprovado'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresNaoAprovadosMes = $res['total'] ?? 0;

// Buscar pareceres não aprovados no ano atual
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE ano = YEAR(CURDATE()) AND parecerRelator = 'naoAprovado'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresNaoAprovadosAno = $res['total'] ?? 0;

// Buscar total de todos os pareceres não aprovados
$query = $pdo->query("SELECT COUNT(*) as total FROM pareceres WHERE parecerRelator = 'naoAprovado'");
$res = $query->fetch(PDO::FETCH_ASSOC);
$totalPareceresNaoAprovadosTodos = $res['total'] ?? 0;

$meses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

$mes_atual = $meses[(int)date('n')];
$ano_atual = date('Y');


?>


<div class="main-page">
    <div class="col_3">
        <!-- Card 1: Pareceres Mensais (Visível para todos) -->
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-file-powerpoint-o user1 icon-rounded"></i>
                <div class="stats">
                    <h5><strong><big><?php echo $totalPareceresAno ?></big></strong></h5>
                    <hr style="margin-top: -2px; margin-bottom: 3px">
                    <h6><span><strong>Pareceres Mensais <?php echo "$mes_atual/$ano_atual"; ?></strong></span></h6>				
                </div>
            </div>
        </div>

        <!-- Card 2: Total Pareceres no Ano (Visível para todos) -->
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-file-text-o icon-rounded"></i>
                <div class="stats">
                    <h5><strong><big><?php echo $totalPareceresAno ?></big></strong></h5>
                    <hr style="margin-top: -2px; margin-bottom: 3px">
                    <h6><span><strong>Total Pareceres emitidos em <?php echo $ano_atual; ?></strong></span></h6>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Pareceres Sistema (Visível para todos) -->
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-file user2 icon-rounded"></i>
                <div class="stats">
                    <h5><strong><big><?php echo $totalPareceresAno ?></big></strong></h5>
                    <hr style="margin-top: -2px; margin-bottom: 3px">			
                    <h6><span><strong>Total Pareceres Sistema</strong></span></h6>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Membros COPEP (Visível para Administrador, Discente, Técnico-Administrativo e Docente) -->
        <a href="index.php?pagina=membros" title="Cadastrar Membro">
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-users dollar1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><big><?php echo $totalMembros ?></big></strong></h5>
                        <hr style="margin-top: -2px; margin-bottom: 3px">
                        <h6><span><strong>Total Membros COPEP</strong></span></h6>
                    </div>
                </div>			
            </div>
        </a>

        <!-- Card 5: Total Usuários Sistema (Visível apenas para Administrador) -->
        <a href="index.php?pagina=usuarios" class="<?php echo $esc_disc . ' ' . $esc_doc . ' ' . $esc_tec ?>" title="Cadastrar Usuário">	
            <div class="col-md-3 widget">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><big><?php echo $totalUsuarios ?></big></strong></h5>
                        <hr style="margin-top: -2px; margin-bottom: 3px">
                        <h6><span><strong>Total Usuários Sistema</strong></span></h6>
                    </div>
                </div>
            </div>
        </a>

        <div class="clearfix"></div>
    </div>
</div>



	
	<div class="row-one widgettable">
	    <!-- Primeiro bloco: Gráfico de Pareceres -->
	    <div class="col-md-5 content-top-2 card">
	        <div class="agileinfo-cdr">
	            <div class="card-header">
	                <h3>Pareceres Emitidos</h3>
	            </div>
	            <canvas id="ChartGraph" style="width: 100%; height: 350px"></canvas>
	            <div id="LineGraphFallback" style="width: 100%; height: 350px; display: none;"></div>
	        </div>
	    </div>
	    <!-- Outros blocos da row-one, se houver, podem ser adicionados aqui -->
	</div>


	    <!-- Segundo bloco: Tarefas, Reviews, Visitors -->
	   <div class="col-md-3 stat">    
		   <a href="index.php?pagina=agenda">
			    <div class="content-top-1">
			        <div class="col-md-7 top-content">
			            <h5>Tarefas Concluídas Hoje</h5>
			            <label><?php echo $totalTarefasConcluidasHoje; ?> de <?php echo $totalTarefasHoje; ?></label>
			        </div>
			        <div class="col-md-5 top-content1">
			            <div id="demo-pie-1" class="pie-title-center" data-percent="<?php echo $porcentagemTarefas; ?>">
			                <span class="pie-value"></span>
			            </div>
			        </div>
			        <div class="clearfix"></div>
			    </div>
		   </a>

	    <!-- Bloco 2: Pareceres Aprovados (Mês) -->
	    <div class="content-top-1">
	        <div class="col-md-7 top-content">  
	            <h5>Pareceres Aprovados (Mês)</h5>
	            <label><?php echo $totalPareceresAprovadosMes; ?> de <?php echo $totalPareceresMes; ?></label>
	        </div>
	        <div class="col-md-5 top-content1">
	            <div id="demo-pie-2" class="pie-title-center" data-percent="<?php echo ($totalPareceresMes > 0) ? ($totalPareceresAprovadosMes / $totalPareceresMes) * 100 : 0; ?>">
	                <span class="pie-value"><?php echo ($totalPareceresMes > 0) ? round(($totalPareceresAprovadosMes / $totalPareceresMes) * 100, 1) : 0; ?>%</span>
	            </div>
	        </div>
	        <div class="clearfix"></div>
	    </div>

	    <!-- Bloco 3: Membros Ativos -->
	    <div class="content-top-1">
	        <div class="col-md-7 top-content">
	            <h5>Membros Ativos</h5>
	            <label><?php echo $totalMembros; ?></label>
	        </div>
	        <div class="col-md-5 top-content1">
	            <div id="demo-pie-3" class="pie-title-center" data-percent="100">
	                <span class="pie-value">100%</span>
	            </div>
	        </div>
	        <div class="clearfix"></div>
	    </div>
	</div>



    <!-- Terceiro bloco: Últimos Logs -->
    <div class="col-md-3 w3-agile-crd">
        <div class="card">
            <div class="card-body card-padding">
                <header class="widget-header">
                    <h4 class="widget-title">Últimos Logs</h4>
                </header>
                <hr style="margin-top: -2px; margin-bottom: 29px">
                <div class="widget-body">
                    <div class="streamline">
                        <?php 
                        $query = $pdo->query("SELECT * FROM logs ORDER BY id DESC LIMIT 5");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                        $total_reg = @count($res);
                        if ($total_reg > 0) {
                            for ($i = 0; $i < $total_reg; $i++) {
                                $hora = $res[$i]['hora'];
                                $usuario = $res[$i]['usuario'];
                                $agora = date('H:i:s');

                                $tempo_minutos = gmdate('i', strtotime($agora) - strtotime($hora));
                                $tempo_hora = gmdate('H', strtotime($agora) - strtotime($hora));

                                if ($tempo_hora < 10) {
                                    $tempo_horaF = str_replace('0', '', $tempo_hora);
                                } else {
                                    $tempo_horaF = $tempo_hora;
                                }

                                if ($tempo_hora == "00") {
                                    $tempo = $tempo_minutos . ' Minutos ';
                                } else if ($tempo_hora == "01") {
                                    $tempo = $tempo_horaF . ' Hora ';
                                } else {
                                    $tempo = $tempo_horaF . ' Horas ';
                                }

                                $query2 = $pdo->query("SELECT * FROM usuarios WHERE id = '$usuario'");
                                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                $nome_usu = (@count($res2) > 0) ? $res2[0]['nome'] : 'Sem Usuário';

                                $classe = ($i == 0) ? "sl-primary" : (($i == 1) ? "sl-danger" : (($i == 2) ? "sl-success" : (($i == 3) ? "sl-content" : "sl-warning")));
                                ?>
                                <div class="sl-item <?php echo $classe ?>">
                                    <div class="sl-content">
                                        <small class="text-muted"><?php echo $tempo ?> Atrás</small>
                                        <p style="font-size: 13px"><?php echo $nome_usu ?> - <?php echo $res[$i]['tabela'] ?> / <?php echo $res[$i]['acao'] ?></p>
                                    </div>
                                </div>
                            <?php } 
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Scripts apenas para Chart.js e SimpleChart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/SimpleChart.js"></script>
<script>
    // Dados comuns para ambos os gráficos
    var labels = ["Mês Atual (<?php echo $mes_atual; ?>)", "Ano (<?php echo $ano_atual; ?>)", "Total Sistema"];
    var totalData = [<?php echo $totalPareceresMes; ?>, <?php echo $totalPareceresAno; ?>, <?php echo $totalPareceresTodos; ?>];
    var aprovadosData = [<?php echo $totalPareceresAprovadosMes; ?>, <?php echo $totalPareceresAprovadosAno; ?>, <?php echo $totalPareceresAprovadosTodos; ?>];
    var naoAprovadosData = [<?php echo $totalPareceresNaoAprovadosMes; ?>, <?php echo $totalPareceresNaoAprovadosAno; ?>, <?php echo $totalPareceresNaoAprovadosTodos; ?>];

    $(document).ready(function () {
        // Função para verificar conexão com a internet
        function checkInternetConnection(callback) {
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', 'https://cdn.jsdelivr.net/npm/chart.js', true);
            xhr.timeout = 5000; // Timeout de 5 segundos
            xhr.onload = function () {
                callback(true); // Internet disponível
            };
            xhr.onerror = function () {
                callback(false); // Sem internet ou erro
            };
            xhr.ontimeout = function () {
                callback(false); // Timeout (sem internet)
            };
            xhr.send();
        }

        // Verifica a conexão e escolhe o gráfico
        checkInternetConnection(function (isOnline) {
            if (isOnline && typeof Chart !== 'undefined') {
                // Debug dos dados antes de criar o gráfico
                console.log("Dados para Chart.js:");
                console.log("Total:", totalData);
                console.log("Aprovados:", aprovadosData);
                console.log("Não Aprovados:", naoAprovadosData);

                // Gráfico de barras com Chart.js
                console.log("Internet disponível e Chart.js carregado - usando gráfico de barras");
                var ctx = document.getElementById('ChartGraph').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Pareceres',
                                data: totalData,
                                backgroundColor: '#CCA300', // Amarelo
                                barThickness: 20
                            },
                            {
                                label: 'Pareceres Aprovados',
                                data: aprovadosData,
                                backgroundColor: '#00CC66', // Verde
                                barThickness: 20
                            },
                            {
                                label: 'Pareceres Não Aprovados',
                                data: naoAprovadosData,
                                backgroundColor: '#FF3333', // Vermelho
                                barThickness: 20
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 30,
                                    stepSize: 5
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Quantidade'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Período'
                                }
                            }]
                        },
                        plugins: {
                            legend: { position: 'bottom' },
                            title: { display: true, text: 'Pareceres Emitidos' }
                        }
                    }
                });

                // Debug da escala aplicada
                console.log("Escala Y aplicada:", myChart.scales['y-axis-0'].min, "até", myChart.scales['y-axis-0'].max);
            } else {
                // Fallback para SimpleChart.js (linhas)
                console.log("Sem internet ou Chart.js não carregado - usando SimpleChart.js como fallback");
                document.getElementById('ChartGraph').style.display = 'none';
                document.getElementById('LineGraphFallback').style.display = 'block';

                var graphdataTotal = {
                    linecolor: "#CCA300",
                    title: "Total Pareceres",
                    values: [
                        { X: "Mês Atual (<?php echo $mes_atual; ?>)", Y: <?php echo $totalPareceresMes; ?> },
                        { X: "Ano (<?php echo $ano_atual; ?>)", Y: <?php echo $totalPareceresAno; ?> },
                        { X: "Total Sistema", Y: <?php echo $totalPareceresTodos; ?> }
                    ]
                };

                var graphdataAprovados = {
                    linecolor: "#00CC66",
                    title: "Pareceres Aprovados",
                    values: [
                        { X: "Mês Atual (<?php echo $mes_atual; ?>)", Y: <?php echo $totalPareceresAprovadosMes; ?> },
                        { X: "Ano (<?php echo $ano_atual; ?>)", Y: <?php echo $totalPareceresAprovadosAno; ?> },
                        { X: "Total Sistema", Y: <?php echo $totalPareceresAprovadosTodos; ?> }
                    ]
                };

                var graphdataNaoAprovados = {
                    linecolor: "#FF3333",
                    title: "Pareceres Não Aprovados",
                    values: [
                        { X: "Mês Atual (<?php echo $mes_atual; ?>)", Y: <?php echo $totalPareceresNaoAprovadosMes; ?> },
                        { X: "Ano (<?php echo $ano_atual; ?>)", Y: <?php echo $totalPareceresNaoAprovadosAno; ?> },
                        { X: "Total Sistema", Y: <?php echo $totalPareceresNaoAprovadosTodos; ?> }
                    ]
                };

                $("#LineGraphFallback").SimpleChart({
                    ChartType: "Line",
                    toolwidth: "50",
                    toolheight: "25",
                    axiscolor: "#E6E6E6",
                    textcolor: "#6E6E6E",
                    showlegends: true,
                    data: [graphdataTotal, graphdataAprovados, graphdataNaoAprovados],
                    legendsize: "140",
                    legendposition: 'bottom',
                    xaxislabel: 'Período',
                    title: 'Pareceres Emitidos',
                    yaxislabel: 'Quantidade'
                });
            }
        });
    });
</script>	