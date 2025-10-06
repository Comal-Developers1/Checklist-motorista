<?php
session_start();
$loginError = "";

if (isset($_POST['submit'])) {
    function conectarOracle() {
        $usuario = "COMAL";
        $senha = "COMAL";
        $CLIENTEBanco = "WINT";
        $host = "192.168.1.3";

        $conn = oci_connect($usuario, $senha, $host . '/' . $CLIENTEBanco);
        return $conn ?: false;
    }

    $connection = conectarOracle();

    if (!$connection) {
        echo "Não foi possível conectar ao banco de dados Oracle.";
        exit;
    }

    $cpf = $_POST["cpf"];
    $query = "SELECT E.NOME_GUERRA, E.MATRICULA FROM PCEMPR E WHERE TIPO = 'M' AND SITUACAO = 'A' AND E.CPF = :cpf";
    $stmt = oci_parse($connection, $query);
    oci_bind_by_name($stmt, ':cpf', $cpf);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);

    if ($row) {
        $_SESSION["authenticated"] = $cpf;
        $_SESSION["nome_guerra"] = $row['NOME_GUERRA'];
        $_SESSION["matricula"] = $row['MATRICULA'];
        header("Location: index.php");
        exit;
    } else {
        $loginError = "CPF incorreto. Tente novamente.";
    }

    oci_free_statement($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #27ae60;
        }

        .form-control:focus {
            border-color: #2ecc71;
            box-shadow: 0 0 5px rgba(46, 204, 113, 0.5);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            background: linear-gradient(to right, #2ecc71, #27ae60);
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #27ae60, #2ecc71);
        }

        .alert {
            margin-top: 15px;
            border-radius: 8px;
        }

        .forgot {
            display: block;
            text-align: right;
            margin-top: 10px;
            font-size: 0.9em;
            color: #27ae60;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Motoristas</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="cpf" class="form-control" placeholder="CPF" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Entrar</button>

            <?php if (!empty($loginError)): ?>
                <div class="alert alert-danger">
                    <?php echo $loginError; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
