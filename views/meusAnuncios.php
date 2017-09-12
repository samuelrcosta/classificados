<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <h1>Meus Anúncios</h1>
    <a href="<?php echo BASE_URL;?>/home/addAnuncio" class="btn btn-success" style="margin-top:10px">Novo Anúncio</a>
    <table class="table table-striped" style="margin-top: 20px">
        <thead>
        <th>Foto</th>
        <th>Titulo</th>
        <th>Valor</th>
        <th>Ações</th>
        </thead>
        <?php
        foreach ($anuncios as $anuncio):
            ?>
            <tr style="line-height: 55px">
                <?php if(!empty($anuncio['url'])): ?>
                    <td><img src="<?php echo BASE_URL;?>/assets/imgs/anuncios/<?php echo $anuncio['url'] ?>" style="height: 60px"></td>
                <?php else: ?>
                    <td><img src="<?php echo BASE_URL;?>/assets/imgs/default.png" style="height: 60px"></td>
                <?php endif; ?>
                <td><?php echo $anuncio['titulo'] ?></td>
                <td>R$ <?php echo str_replace(".", ",", $anuncio['valor']) ?></td>
                <td>
                    <a class="btn btn-info" href="<?php echo BASE_URL;?>/home/editarAnuncio/<?php echo base64_encode(base64_encode($anuncio['id'])) ?>">Editar</a>
                    <a class="btn btn-warning" href="<?php echo BASE_URL;?>/home/excluirAnuncio/<?php echo base64_encode(base64_encode($anuncio['id'])) ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>