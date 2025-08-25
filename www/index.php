<?php
session_start();

// Verifique se o usuário está autenticado
if (isset($_SESSION["authenticated"])) {
    $nomeGuerra = $_SESSION["nome_guerra"];
    $matricula = $_SESSION["matricula"];

    // Agora você pode usar $nomeGuerra e $matricula conforme necessário
} else {
    // Se não estiver autenticado, redirecione para a página de login ou faça qualquer outra manipulação necessária
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Checklist</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container">
        <h1>Formulário de Checklist</h1>
        <p>Bem-vindo, <?php echo $nomeGuerra; ?>!</p>
        <a href="logout.php" class="btn btn-danger">Sair</a>
    </div>



    <form method="post" action="">
<!-- Dropdown (seleção) para as opções de placas -->
<select name="placa" required>
    <option value="">Selecione uma placa</option>
    <option value="PFZ 1973">PFZ 1973</option>
    <option value="KIM 7767">KIM 7767</option>
    <option value="OYV 2892">OYV 2892</option>
    <option value="PCD 7092">PCD 7092</option>
    <option value="PCD 7222">PCD 7222</option>
    <option value="PEA 2926">PEA 2926</option>
    <option value="PDO 4015">PDO 4015</option>
    <option value="PCA 6189">PCA 6189</option>
    <option value="PCY 4619">PCY 4619</option>
    <option value="PDU 4115">PDU 4115</option>
    <option value="PCO 7869">PCO 7869</option>
    <option value="QYC 6248">QYC 6248</option>
    <option value="QYD 9292">QYD 9292</option>
    <option value="QYD 8589">QYD 8589</option>
    <option value="QYE 0018">QYE 0018</option>
    <option value="QYG 0H24">QYG 0H24</option>
    <option value="QYI 6C13">QYI 6C13</option>
    <option value="QYJ 2D38">QYJ 2D38</option>
    <option value="QYJ 8H95">QYJ 8H95</option>
    <option value="QYI 6C73">QYI 6C73</option>
    <option value="QYR 0H28">QYR 0H28</option>
    <option value="QYU 7J88">QYU 7J88</option>
</select>
<label for="combustivel">Nível de Combustível:</label>
        <select name="nivel_combustivel" id="nivel_combustivel" onchange="atualizarCorBarra()">
            <option value="1">Nível 1</option>
            <option value="2">Nível 2</option>
            <option value="3">Nível 3</option>
            <option value="4">Nível 4</option>
        </select>

        <!-- Indicador de nível de combustível -->
        <div class="nivel-combustivel" id="barra_nivel"></div>

        <label for="chave_roda">Chave de Roda:</label>
        <select name="chave_roda_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- Cinto de Segurança -->
        <label for="cinto_seguranca">Cinto de Segurança:</label>
        <select name="cinto_seguranca_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- Estepe -->
        <label for="estepe">Estepe:</label>
        <select name="estepe_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- Extintor -->
        <label for="extintor">Extintor:</label>
        <select name="extintor_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- Macaco -->
        <label for="macaco">Macaco:</label>
        <select name="macaco_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- Placa Lacre -->
        <label for="placa_lacre">Placa Lacre:</label>
        <select name="placa_lacre_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- Triângulo Sinalizador -->
        <label for="tri_sinalizador">Triângulo Sinalizador:</label>
        <select name="tri_sinalizador_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <!-- CRLV -->
        <label for="crlv">CRLV:</label>
        <select name="crlv_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM">BOM</option>
            <option value="RUIM">RUIM</option>
            <option value="FALTA">FALTA</option>
        </select>

        <label for="freio_pedal">Freio de Pedal:</label>
        <select name="freio_pedal_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Estacionamento Manual -->
        <label for="estacionamento_manual">Estacionamento Manual:</label>
        <select name="estacionamento_manual_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Buzina -->
        <label for="buzina">Buzina:</label>
        <select name="buzina_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Alarme -->
        <label for="alarme">Alarme:</label>
        <select name="alarme_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Farol -->
        <label for="farol">Farol:</label>
        <select name="farol_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Iluminação da Placa -->
        <label for="iluminacao_placa">Iluminação da Placa:</label>
        <select name="iluminacao_placa_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Lanterna -->
        <label for="lanterna">Lanterna:</label>
        <select name="lanterna_status" class="status-options">
            <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <label for="limp_parabrisa">Limpador de Para-brisa:</label>
        <select name="limp_parabrisa_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Sinaleira -->
        <label for="sinaleira">Sinaleira:</label>
        <select name="sinaleira_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Pneu Dianteiro -->
        <label for="pneu_dianteiro">Pneu Dianteiro:</label>
        <select name="pneu_dianteiro_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Pneu Traseiro -->
        <label for="pneu_traseiro">Pneu Traseiro:</label>
        <select name="pneu_traseiro_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Cabine -->
        <label for="cabine">Cabine:</label>
        <select name="cabine_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Carroceria Baú -->
        <label for="carroceria_bau">Carroceria Baú:</label>
        <select name="carroceria_bau_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Para-choque -->
        <label for="para_choque">Para-choque:</label>
        <select name="para_choque_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Para-lama -->
        <label for="para_lama">Para-lama:</label>
        <select name="para_lama_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Para-brisa -->
        <label for="para_brisa">Para-brisa:</label>
        <select name="para_brisa_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Retrovisor -->
        <label for="retrovisor">Retrovisor:</label>
        <select name="retrovisor_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Vidro da Porta -->
        <label for="vidro_porta">Vidro da Porta:</label>
        <select name="vidro_porta_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Trava do Tanque -->
        <label for="trava_tanque">Trava do Tanque:</label>
        <select name="trava_tanque_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <!-- Carrinho de Entrega -->
        <label for="carrinho">Carrinho De Entrega:</label>
        <select name="carrinho_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="BOM" class="status-bom">BOM</option>
            <option value="RUIM" class="status-ruim">RUIM</option>
        </select>

        <label for="vazamento">Veículo apresenta vazamentos:</label>
        <select name="vazamento_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="SIM" class="status-ruim">SIM</option>
            <option value="NÃO" class="status-bom">NÃO</option>
        </select>

        <!-- Veículo se apresenta limpo -->
        <label for="limpo">Veículo se apresenta limpo:</label>
        <select name="limpo_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="SIM" class="status-bom">SIM</option>
            <option value="NÃO" class="status-ruim">NÃO</option>
        </select>

        <!-- Equipamento de frio está em condições -->
        <label for="frio">Equipamento de frio está em condições:</label>
        <select name="frio_status" class="status-options">
        <option value="">Selecione uma opção</option>
            <option value="SIM" class="status-bom">SIM</option>
            <option value="NÃO" class="status-ruim">NÃO</option>
        </select>

        <label for="obs">Observações:</label>
        <textarea name="obs" rows="4" cols="50" required></textarea>

        <input type="submit" name="submit" value="Enviar">
    </form>
    <?php
function conectarOracle() {
    $usuario = "COMAL";
    $senha = "COMAL";
    $CLIENTEBanco = "WINT";
    $host = "srvoracle";

    $conn = oci_connect($usuario, $senha, $host . '/' . $CLIENTEBanco);

    if (!$conn) {
        $error = oci_error();
        echo "Falha na conexão com o Oracle: " . $error['message'];
        return false;
    } else {
        return $conn;
    }
}

function verificarEntradaExistente($oracleConn, $matricula, $dataFormatada) {
    $sql = "SELECT COUNT(*) AS COUNT FROM cmlchlist WHERE MATRICULA = :matricula AND TRUNC(DATA) = TRUNC(TO_DATE(:data, 'YYYY-MM-DD HH24:MI:SS'))";
    
    $stid = oci_parse($oracleConn, $sql);
    oci_bind_by_name($stid, ':matricula', $matricula);
    oci_bind_by_name($stid, ':data', $dataFormatada);
    oci_execute($stid);

    $row = oci_fetch_assoc($stid);

    return $row['COUNT'] > 0;
}

if (isset($_POST['submit'])) {
    $oracleConn = conectarOracle();

    if ($oracleConn) {
        $matricula = $_SESSION['matricula'];
        $nome = $_SESSION['nome_guerra'];
        $data = isset($_POST['data']) ? $_POST['data'] : "";
        $timezone = new DateTimeZone('America/Sao_Paulo'); // Configura o fuso horário de Brasília
        
        if (!empty($data)) {
            $dateTime = new DateTime($data, $timezone);
            $dataFormatada = $dateTime->format('Y-m-d H:i:s');
        } else {
            $dateTimeNow = new DateTime('now', $timezone);
            $dataFormatada = $dateTimeNow->format('Y-m-d H:i:s');
        }
        

        if (!verificarEntradaExistente($oracleConn, $matricula, $dataFormatada)) {

        // Obtém outros dados do formulário
        $placa = isset($_POST['placa']) ? $_POST['placa'] : "";
        $combustivel = isset($_POST['nivel_combustivel']) ? $_POST['nivel_combustivel'] : "";
        $chave_roda = isset($_POST['chave_roda_status']) ? $_POST['chave_roda_status'] : "";
        $cinto_seguranca = isset($_POST['cinto_seguranca_status']) ? $_POST['cinto_seguranca_status'] : "";
        $estepe = isset($_POST['estepe_status']) ? $_POST['estepe_status'] : "";
        $extintor = isset($_POST['extintor_status']) ? $_POST['extintor_status'] : "";
        $macaco = isset($_POST['macaco_status']) ? $_POST['macaco_status'] : "";
        $placa_lacre = isset($_POST['placa_lacre_status']) ? $_POST['placa_lacre_status'] : "";
        $tri_sinalizador = isset($_POST['tri_sinalizador_status']) ? $_POST['tri_sinalizador_status'] : "";
        $crlv = isset($_POST['crlv_status']) ? $_POST['crlv_status'] : "";
        $freio_pedal = isset($_POST['freio_pedal_status']) ? $_POST['freio_pedal_status'] : "";
        $estacionamento_manual = isset($_POST['estacionamento_manual_status']) ? $_POST['estacionamento_manual_status'] : "";
        $buzina = isset($_POST['buzina_status']) ? $_POST['buzina_status'] : "";
        $alarme = isset($_POST['alarme_status']) ? $_POST['alarme_status'] : "";
        $farol = isset($_POST['farol_status']) ? $_POST['farol_status'] : "";
        $iluminacao_placa = isset($_POST['iluminacao_placa_status']) ? $_POST['iluminacao_placa_status'] : "";
        $lanterna = isset($_POST['lanterna_status']) ? $_POST['lanterna_status'] : "";
        $limp_parabrisa = isset($_POST['limp_parabrisa_status']) ? $_POST['limp_parabrisa_status'] : "";
        $sinaleira = isset($_POST['sinaleira_status']) ? $_POST['sinaleira_status'] : "";
        $pneu_dianteiro = isset($_POST['pneu_dianteiro_status']) ? $_POST['pneu_dianteiro_status'] : "";
        $pneu_traseiro = isset($_POST['pneu_traseiro_status']) ? $_POST['pneu_traseiro_status'] : "";
        $cabine = isset($_POST['cabine_status']) ? $_POST['cabine_status'] : "";
        $carroceria_bau = isset($_POST['carroceria_bau_status']) ? $_POST['carroceria_bau_status'] : "";
        $para_choque = isset($_POST['para_choque_status']) ? $_POST['para_choque_status'] : "";
        $para_lama = isset($_POST['para_lama_status']) ? $_POST['para_lama_status'] : "";
        $para_brisa = isset($_POST['para_brisa_status']) ? $_POST['para_brisa_status'] : "";
        $retrovisor = isset($_POST['retrovisor_status']) ? $_POST['retrovisor_status'] : "";
        $vidro_porta = isset($_POST['vidro_porta_status']) ? $_POST['vidro_porta_status'] : "";
        $trava_tanque = isset($_POST['trava_tanque_status']) ? $_POST['trava_tanque_status'] : "";
        $carrinho = isset($_POST['carrinho_status']) ? $_POST['carrinho_status'] : "";
        $vazamento = isset($_POST['vazamento_status']) ? $_POST['vazamento_status'] : "";
        $limpo = isset($_POST['limpo_status']) ? $_POST['limpo_status'] : "";
        $frio = isset($_POST['frio_status']) ? $_POST['frio_status'] : "";
        $obs = isset($_POST['obs']) ? $_POST['obs'] : "";
        // Query SQL para inserção no banco de dados
        $sql = "INSERT INTO cmlchlist (ID, MATRICULA, DATA, NOME, PLACA, COMBUSTIVEL, CHAVERODA, CINTOSEG, ESTEPE, EXTINTOR, MACACO, PLACALACRE, TRISINALIZADOR, CRLV, FREIOPEDAL, ESTACIMANETE, BUZINA, ALARMRE, FAROL, ILUPLACA, LANTERNA, LIMPPARABRISA, SINALEIRA, PNEUD, PNEUT, CABINE, CARROCERIABAU, PARACHOQUE, PARALAMA, PARABRISA, RETROVISOR, VIDROPORTA, TRAVATANQUE, CARRINHO, VAZAMENTO, LIMPO, FRIO, OBS) VALUES (1, :matricula, TO_DATE(:data, 'YYYY-MM-DD HH24:MI:SS'), :nome, :placa, :combustivel, :chave_roda, :cinto_seguranca, :estepe, :extintor, :macaco, :placa_lacre, :tri_sinalizador, :crlv, :freio_pedal, :estacionamento_manual, :buzina, :alarme, :farol, :iluminacao_placa, :lanterna, :limp_parabrisa, :sinaleira, :pneu_dianteiro, :pneu_traseiro, :cabine, :carroceria_bau, :para_choque, :para_lama, :para_brisa, :retrovisor, :vidro_porta, :trava_tanque, :carrinho, :vazamento, :limpo, :frio, :obs)";
        

        $stid = oci_parse($oracleConn, $sql);

        // Vincular parâmetros
        oci_bind_by_name($stid, ':matricula', $matricula);
        oci_bind_by_name($stid, ':data', $dataFormatada);
        oci_bind_by_name($stid, ':nome', $nome);
        oci_bind_by_name($stid, ':placa', $placa);
        oci_bind_by_name($stid, ':combustivel', $combustivel);
        oci_bind_by_name($stid, ':chave_roda', $chave_roda);
        oci_bind_by_name($stid, ':cinto_seguranca', $cinto_seguranca);
        oci_bind_by_name($stid, ':estepe', $estepe);
        oci_bind_by_name($stid, ':extintor', $extintor);
        oci_bind_by_name($stid, ':macaco', $macaco);
        oci_bind_by_name($stid, ':placa_lacre', $placa_lacre);
        oci_bind_by_name($stid, ':tri_sinalizador', $tri_sinalizador);
        oci_bind_by_name($stid, ':crlv', $crlv);
        oci_bind_by_name($stid, ':freio_pedal', $freio_pedal);
        oci_bind_by_name($stid, ':estacionamento_manual', $estacionamento_manual);
        oci_bind_by_name($stid, ':buzina', $buzina);
        oci_bind_by_name($stid, ':alarme', $alarme);
        oci_bind_by_name($stid, ':farol', $farol);
        oci_bind_by_name($stid, ':iluminacao_placa', $iluminacao_placa);
        oci_bind_by_name($stid, ':lanterna', $lanterna);
        oci_bind_by_name($stid, ':limp_parabrisa', $limp_parabrisa);
        oci_bind_by_name($stid, ':sinaleira', $sinaleira);
        oci_bind_by_name($stid, ':pneu_dianteiro', $pneu_dianteiro);
        oci_bind_by_name($stid, ':pneu_traseiro', $pneu_traseiro);
        oci_bind_by_name($stid, ':cabine', $cabine);
        oci_bind_by_name($stid, ':carroceria_bau', $carroceria_bau);
        oci_bind_by_name($stid, ':para_choque', $para_choque);
        oci_bind_by_name($stid, ':para_lama', $para_lama);
        oci_bind_by_name($stid, ':para_brisa', $para_brisa);
        oci_bind_by_name($stid, ':retrovisor', $retrovisor);
        oci_bind_by_name($stid, ':vidro_porta', $vidro_porta);
        oci_bind_by_name($stid, ':trava_tanque', $trava_tanque);
        oci_bind_by_name($stid, ':carrinho', $carrinho);
        oci_bind_by_name($stid, ':vazamento', $vazamento);
        oci_bind_by_name($stid, ':limpo', $limpo);
        oci_bind_by_name($stid, ':frio', $frio);
        oci_bind_by_name($stid, ':obs', $obs);

        // Executar a inserção
        oci_execute($stid);

        // Lembre-se de fechar a conexão Oracle quando terminar
        oci_close($oracleConn);

        echo '
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#myModal").modal();
            });
        </script>
        
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agradecimento</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Obrigado por enviar os dados!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    ';
} else {
    echo '
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#myModalDuplicate").modal();
            });
        </script>
        
        <div class="modal" id="myModalDuplicate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Aviso</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Você já inseriu dados hoje.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    ';
}
}
}
?>

    <!-- Scripts do Cordova -->
    <script src="cordova.js"></script>
    <script src="js/index.js"></script>
    <script>
            function atualizarCorBarra() {
                var nivelSelecionado = document.getElementById("nivel_combustivel").value;
                var barraNivel = document.getElementById("barra_nivel");

                // Remover todas as classes de nível
                barraNivel.className = "nivel-combustivel";

                // Adicionar a classe correspondente ao nível selecionado
                barraNivel.classList.add("nivel-" + nivelSelecionado);
            }
        </script>
</body>
</html>
