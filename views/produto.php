<div class="container-fluid" style="margin-top: 15px">
    <div class="row">
        <div class="col-sm-5">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <?php if(!isset($info['fotos'])): ?>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img style="margin: auto;" class="img-responsive" src="<?php echo BASE_URL;?>/assets/imgs/default.png" alt="First slide">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="carousel-inner" role="listbox">
                        <ol class="carousel-indicators">
                            <?php for($q = 0; $q < count($info['fotos']); $q++): ?>
                                <li data-target="#myCarousel" data-slide-to="<?php echo $q ?>" class="<?php echo ($q == '0')?'active':'' ?>"></li>
                            <?php endfor; ?>
                        </ol>
                        <?php foreach ($info['fotos'] as $chave => $foto): ?>
                            <div class="carousel-item <?php echo ($chave == '0')?'active':'' ?>">
                                <img style="margin: auto;" class="img-responsive" src="<?php echo BASE_URL;?>/assets/imgs/anuncios/<?php echo $foto['url']; ?>" alt="Slide <?php echo $chave ?>">
                            </div>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-sm-7">
            <h1><?php echo $info['titulo'] ?></h1>
            <h4><?php echo $info['categoria'] ?></h4>
            <p><pre><?php echo $info['descricao'] ?></pre><br>
            Estado: <?php if($info['estado'] == '1'): ?>Ruim
            <?php elseif($info['estado'] == '2'): ?>Bom
            <?php elseif($info['estado'] == '3'): ?>Ótimo
            <?php elseif($info['estado'] == '4'): ?>Novo
            <?php endif; ?>
            </p>
            <br>
            <h3>R$ <?php echo str_replace(".",",",$info['valor']) ?></h3>
            <br>
            <h6>Nome: <?php echo $info['nome'] ?></h6>
            <h6>Celular: <?php echo $info['celular'] ?></h6>
            <h6>Telefone: <?php echo $info['telefone'] ?></h6>
        </div>
    </div>
</div>