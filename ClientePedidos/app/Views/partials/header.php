<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cantina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card img{ height:160px; object-fit:cover; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="<?= site_url('/') ?>">Cantina</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= site_url('produtos') ?>">Produtos</a></li>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php $carrinho = session()->get('carrinho') ?? []; $count = count($carrinho); ?>
        <li class="nav-item">
          <a class="btn btn-outline-light" href="<?= site_url('carrinho') ?>">
            Carrinho <span class="badge bg-light text-primary"><?= $count ?></span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container mt-4">
