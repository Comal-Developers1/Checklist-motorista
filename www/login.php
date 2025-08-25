<?php
session_start();
$loginError = ""; // Inicialize a mensagem de erro vazia

if (isset($_POST['submit'])) {
    // Função para conectar ao banco de dados Oracle
    function conectarOracle() {
        // Coloque suas informações de conexão aqui
        $usuario = "COMAL";
        $senha = "COMAL";
        $CLIENTEBanco = "WINT";
        $host = "srvoracle"; // or Oracle server address

        $conn = oci_connect($usuario, $senha, $host . '/' . $CLIENTEBanco);

        if (!$conn) {
            $error = oci_error();
            return false;
        } else {
            return $conn;
        }
    }

    $connection = conectarOracle();

    if (!$connection) {
        echo "Não foi possível conectar ao banco de dados Oracle.";
        exit;
    }

    // Processar o formulário de login
    $cpf = $_POST["cpf"];

    $query = "
        SELECT E.NOME_GUERRA, E.MATRICULA
        FROM PCEMPR E
        WHERE TIPO = 'M' AND SITUACAO = 'A' AND E.CPF = :cpf
    ";

    $stmt = oci_parse($connection, $query);
    oci_bind_by_name($stmt, ':cpf', $cpf);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        // Armazene informações na sessão
        $_SESSION["authenticated"] = $cpf;
        $_SESSION["nome_guerra"] = $row['NOME_GUERRA'];
        $_SESSION["matricula"] = $row['MATRICULA'];

        header("Location: index.php"); // Redirecionar para a página restrita após o login
        exit;
    } else {
        $loginError = "CPF incorreto. Tente novamente."; // Define a mensagem de erro
    }

    oci_free_statement($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt/BR">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST">
                    <span class="login100-form-title">
                        Sign In
                    </span>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter CPF">
                        <input class="input100" type="text" name="cpf" placeholder="CPF" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="text-right p-t-13 p-b-23">
                        <span class="txt1">
                            Forgot
                        </span>

                        <a href="#" class="txt2">
                            Username / Password?
                        </a>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit" name="submit">
                            Sign in
                        </button>
                    </div>

                    <!-- Exibir mensagem de erro -->
                    <?php if (!empty($loginError)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $loginError; ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordToggle = document.querySelector('.toggle-password');
            const passwordField = document.querySelector('#senha');

            passwordToggle.addEventListener('click', function () {
                const fieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', fieldType);

                // Troque o ícone de olho aberto/fechado
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>
