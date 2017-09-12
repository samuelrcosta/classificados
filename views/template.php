<html lang="pt-br">
    <head>
        <title><?php echo $titulo ?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo BASE_URL;?>/assets/imgs/logo.png" type="image/png" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/assets/css/style.css">
        <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/tether.min.js"></script>
        <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL;?>'</script>
    </head>
    <body>
        <nav class="navbar navbar-inverse bg-inverse navbar-toggleable-md navbar-light">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="<?php echo BASE_URL;?>">Classificados</a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?>
                        <?php
                        $u = new Usuarios();
                        $u->iniciar(addslashes($_SESSION['cLogin']));
                        echo "<li class='nav-item'><a class='nav-link'>Olá ".$u->getNome()."</a></li>"
                        ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL;?>/home/meusAnuncios">Meus anúncios</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL;?>">Anúncios</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL;?>/login/logout">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL;?>/login/cadastrar">Cadastre-se</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL;?>/login">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <?php $this->loadViewInTemplate($viewName, $viewData) ?>
        <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/canvas-to-blob.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/resize.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>/assets/js/script.js"></script>
    </body>
</html>