<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minha Cantina</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #343a40, #212529);
            height: 100vh;
            margin: 0;
        }

        .auth-container {
            height: 100vh;
        }

        .auth-box {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center auth-container">

    <div class="auth-box">

        <div class="logo">
            Minha Cantina
        </div>

        <?= $this->renderSection('content') ?>

    </div>

</div>

</body>
</html>