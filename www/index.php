<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION["authenticated"])) {
    header("Location: login.php");
    exit;
}

$nomeGuerra = $_SESSION["nome_guerra"];
$matricula  = $_SESSION["matricula"];

// Função para conectar no Oracle
function conectarOracle() {
    $usuario = "COMAL";
    $senha   = "COMAL";
    $CLIENTE = "WINT";
    $host    = "192.168.1.3";

    $conn = oci_connect($usuario, $senha, $host . '/' . $CLIENTE);
    if (!$conn) {
        $error = oci_error();
        echo "Falha na conexão com o Oracle: " . $error['message'];
        return false;
    }
    return $conn;
}


// Processamento do formulário
if (isset($_POST['submit'])) {
    $oracleConn = conectarOracle();
    if ($oracleConn) {
        // Motorista selecionado no select
        $motorista = $_POST['motorista'] ?? "";
        $dadosMotorista = explode("|", $motorista); 
        $nomeMotorista = $dadosMotorista[0] ?? "";
        $matriculaMotorista = (int)($dadosMotorista[1] ?? 0);

        // Usuário logado (quem registrou o checklist)
        $funcregistro = $nomeGuerra;   // da sessão
        $matriculareg = (int)$matricula; // da sessão

        // Outros campos
        $placa = $_POST['placa'] ?? "";
        $combustivel = $_POST['nivel_combustivel'] ?? "";
        $obs = $_POST['obs'] ?? "";

        // Lista dos itens do checklist
        $itensBanco = [
            "CHAVERODA" => "chave_roda_status",
            "CINTOSEG" => "cinto_seguranca_status",
            "ESTEPE" => "estepe_status",
            "EXTINTOR" => "extintor_status",
            "MACACO" => "macaco_status",
            "PLACALACRE" => "placa_lacre_status",
            "TRISINALIZADOR" => "tri_sinalizador_status",
            "CRLV" => "crlv_status",
            "FREIOPEDAL" => "freio_pedal_status",
            "ESTACIMANETE" => "estacionamento_manual_status",
            "BUZINA" => "buzina_status",
            "ALARMRE" => "alarme_status",
            "FAROL" => "farol_status",
            "ILUPLACA" => "iluminacao_placa_status",
            "LANTERNA" => "lanterna_status",
            "LIMPPARABRISA" => "limp_parabrisa_status",
            "SINALEIRA" => "sinaleira_status",
            "PNEUD" => "pneu_dianteiro_status",
            "PNEUT" => "pneu_traseiro_status",
            "CABINE" => "cabine_status",
            "CARROCERIABAU" => "carroceria_bau_status",
            "PARACHOQUE" => "para_choque_status",
            "PARALAMA" => "para_lama_status",
            "PARABRISA" => "para_brisa_status",
            "RETROVISOR" => "retrovisor_status",
            "VIDROPORTA" => "vidro_porta_status",
            "TRAVATANQUE" => "trava_tanque_status",
            "CARRINHO" => "carrinho_status",
            "VAZAMENTO" => "vazamento_status",
            "LIMPO" => "limpo_status",
            "FRIO" => "frio_status",
            "CORUJINHAS" => "corujinhas_status",
            "DIVBAU" => "divbau_status"
        ];

        // Pega MAX(ID)
        $sqlMax = "SELECT NVL(MAX(ID),0) AS MAXID FROM CMLCHLIST";
        $stidMax = oci_parse($oracleConn, $sqlMax);
        oci_execute($stidMax);
        $row = oci_fetch_assoc($stidMax);
        oci_free_statement($stidMax);
        $novoId = strval(($row['MAXID'] ?? 0) + 1);

        // Monta SQL
        $cols = implode(",", array_keys($itensBanco));
        $binds = implode(",", array_map(fn($c) => ":" . $c, array_keys($itensBanco)));

        $sql = "INSERT INTO CMLCHLIST 
            (ID, MATRICULA, NOME, FUNCREGISTRO, MATRICULAREG, DATA, PLACA, COMBUSTIVEL, OBS, $cols)
            VALUES (:id, :matricula, :nome, :funcregistro, :matriculareg, SYSDATE, :placa, :combustivel, :obs, $binds)";

        $stid = oci_parse($oracleConn, $sql);

        // Binds principais
        oci_bind_by_name($stid, ':id', $novoId);
        oci_bind_by_name($stid, ':matricula', $matriculaMotorista);
        oci_bind_by_name($stid, ':nome', $nomeMotorista);
        oci_bind_by_name($stid, ':funcregistro', $funcregistro);
        oci_bind_by_name($stid, ':matriculareg', $matriculareg);
        oci_bind_by_name($stid, ':placa', $placa);
        oci_bind_by_name($stid, ':combustivel', $combustivel);
        oci_bind_by_name($stid, ':obs', $obs);

        // Binds dos itens
        foreach ($itensBanco as $campoBanco => $campoPost) {
            $val = $_POST[$campoPost] ?? null;
            if ($val === "") $val = null;
            oci_bind_by_name($stid, ":$campoBanco", $val, -1);
        }

        $execOk = oci_execute($stid);
        if ($execOk) {
            oci_commit($oracleConn);
            $modal = "sucesso";
        } else {
            $err = oci_error($stid);
            $modal = "erro";
            $errorMessage = $err['message'];
            oci_rollback($oracleConn);
        }

        oci_free_statement($stid);
        oci_close($oracleConn);
    }
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist de Veículos</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos adicionais -->
    <style>
        body {
            background: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin-top: 30px;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .nivel-combustivel {
            height: 15px;
            border-radius: 8px;
            margin: 10px 0;
            transition: background 0.3s ease-in-out;
        }
        .nivel-1 { background: red; }
        .nivel-2 { background: orange; }
        .nivel-3 { background: yellowgreen; }
        .nivel-4 { background: green; }
    </style>
</head>
<body>
    <!-- Modal de status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusModalLabel">
            <?php echo ($modal === 'sucesso') ? 'Sucesso!' : 'Erro!'; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <?php 
            if($modal === 'sucesso'){
                echo 'Checklist enviado com sucesso!';
            } elseif($modal === 'erro'){
                echo 'Ocorreu um erro ao enviar: ' . ($errorMessage ?? '');
            }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Checklist de Veículos</h2>
        <div>
            <span class="me-3">👋 Bem-vindo, <strong><?php echo $nomeGuerra; ?></strong></span>
            <a href="logout.php" class="btn btn-danger btn-sm">Sair</a>
        </div>
    </div>

    <!-- Formulário -->
    <form method="post" action="" class="row g-3">

        <!-- Placa -->
        <div class="col-md-6">
  <label for="placa" class="form-label">Placa do Veículo</label>
  <select name="placa" id="placa" class="form-select" required>
    <option value="">Selecione uma placa</option>
    <?php
    $connection = conectarOracle();

    $sqlPlacas = "
      SELECT DESCRICAO 
      FROM PCVEICUL 
      WHERE SITUACAO = 'V' 
        AND CODVEICULO <> 99
      ORDER BY DESCRICAO
    ";

    $stmtPlacas = oci_parse($connection, $sqlPlacas);
    oci_execute($stmtPlacas);

    while ($row = oci_fetch_assoc($stmtPlacas)) {
        $descricao = $row['DESCRICAO'];
        // Marca como selecionado se o valor já foi enviado antes no form
        $selected = (isset($_GET['placa']) && $_GET['placa'] == $descricao) ? 'selected' : '';
        echo "<option value='$descricao' $selected>$descricao</option>";
    }

    oci_free_statement($stmtPlacas);
    oci_close($connection);
    ?>
  </select>
</div>

<div class="col-md-6">
  <label for="motorista" class="form-label">Motorista</label>
  <select name="motorista" id="motorista" class="form-select" required>
  <option value="">Selecione um motorista</option>
  <?php
  $connection = conectarOracle();

  $sqlMotoristas = "
    SELECT E.NOME_GUERRA, E.MATRICULA
    FROM PCEMPR E
    WHERE E.TIPO = 'M' 
      AND E.SITUACAO = 'A' 
      AND E.MATRICULA NOT IN (100, 3000)
    ORDER BY E.NOME_GUERRA
  ";

  $stmtMotoristas = oci_parse($connection, $sqlMotoristas);
  oci_execute($stmtMotoristas);

  while ($row = oci_fetch_assoc($stmtMotoristas)) {
      $nome = $row['NOME_GUERRA'];
      $matric = $row['MATRICULA'];
      echo "<option value='{$nome}|{$matric}'>Nome: $nome - Matricula: $matric</option>";
  }

  oci_free_statement($stmtMotoristas);
  oci_close($connection);
  ?>
</select>

</div>

        <!-- Aqui começam os itens de checklist -->
        <div class="col-12">
            <h5 class="mt-4">Itens de Segurança</h5>
        </div>

        <?php
        // Lista de campos para simplificar e evitar repetição
        $itens = [
            "chave_roda" => "Chave de Roda",
            "cinto_seguranca" => "Cinto de Segurança",
            "estepe" => "Estepe",
            "extintor" => "Extintor",
            "macaco" => "Macaco",
            "placa_lacre" => "Placa Lacre",
            "tri_sinalizador" => "Triângulo Sinalizador",
            "crlv" => "DOCUEMTAÇÃO ATUALIZADA (CRLV)",
            "freio_pedal" => "Freio de Pedal",
            "estacionamento_manual" => "Estacionamento Manual",
            "buzina" => "Buzina",
            "alarme" => "Alarme",
            "farol" => "Farol",
            "iluminacao_placa" => "Iluminação da Placa",
            "lanterna" => "Lanterna",
            "limp_parabrisa" => "Limpador de Para-brisa",
            "sinaleira" => "Sinaleira",
            "pneu_dianteiro" => "Pneu Dianteiro",
            "pneu_traseiro" => "Pneu Traseiro",
            "cabine" => "Cabine",
            "carroceria_bau" => "Carroceria Baú",
            "para_choque" => "Para-choque",
            "para_lama" => "Para-lama",
            "para_brisa" => "Para-brisa",
            "retrovisor" => "Retrovisor",
            "vidro_porta" => "Vidro da Porta",
            "trava_tanque" => "Trava do Tanque",
            "carrinho" => "Carrinho de Entrega",
            "vazamento" => "Veículo apresenta vazamentos",
            "limpo" => "Veículo se apresenta limpo",
            "frio" => "Equipamento de frio em condições",
            "corujinhas" => "Corujinhas",
            "divbau" => "Divisão do baú"
        ];

        foreach ($itens as $campo => $label) {
            echo "
            <div class='col-md-6'>
                <label for='{$campo}' class='form-label'>{$label}</label>
                <select name='{$campo}_status' id='{$campo}' class='form-select'>
                    <option value=''>Selecione uma opção</option>
                    <option value='BOM'>BOM</option>
                    <option value='RUIM'>RUIM</option>
                    <option value='SIM'>SIM</option>
                    <option value='FALTA'>FALTA</option>
                </select>
            </div>";
        }
        ?>

        <!-- Observações -->
        <div class="col-12">
            <label for="obs" class="form-label">Observações</label>
            <textarea name="obs" id="obs" rows="4" class="form-control" placeholder="Digite suas observações..."></textarea>
        </div>

        <!-- Botão Enviar -->
        <div class="col-12 text-center">
            <button type="submit" name="submit" class="btn btn-primary btn-lg mt-3 w-100">Enviar Checklist</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function atualizarCorBarra() {
    var nivelSelecionado = document.getElementById("nivel_combustivel").value;
    var barraNivel = document.getElementById("barra_nivel");

    // Limpa classes anteriores
    barraNivel.className = "nivel-combustivel";
    // Adiciona cor conforme nível
    barraNivel.classList.add("nivel-" + nivelSelecionado);
}

document.addEventListener("DOMContentLoaded", function(){
    var modalStatus = "<?php echo $modal; ?>";
    if(modalStatus === "sucesso" || modalStatus === "erro"){
        var myModal = new bootstrap.Modal(document.getElementById('statusModal'));
        myModal.show();
    }
});
</script>
</body>
</html>
