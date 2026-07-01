<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>401 - Não Autorizado</title>

    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }
        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }
        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }
        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
        p {
            margin-top: 1.5rem;
        }
        .back-link {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.5rem 1rem;
            background: #dd4814;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background: #c13c0f;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>401</h1>
        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                Você não tem permissão para acessar esta página.
            <?php else : ?>
                Acesso não autorizado.
            <?php endif; ?>
        </p>

        <?php
            $urlAnterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        ?>
        <a href="<?= esc($urlAnterior) ?>">Voltar para a página anterior</a>
    </div>
</body>
</html>