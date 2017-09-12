<script type="text/javascript">
    window.onload = function () {
        $("#valor").mask("#.##0,00", {reverse: true});
    }
</script>
<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <h1>Cadastrar Anúncio</h1>
    <form method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;margin-top: 20px">
        <div class="form-group">
            <label form="categoria">Categoria</label>
            <select name="categoria" id="categoria" class="form-control">
                <?php
                foreach ($cats as $cat):?>
                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['nome'] ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="form-group">
            <label form="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control">
        </div>
        <div class="form-group">
            <label form="titulo">Valor</label>
            <input type="text" name="valor" id="valor" class="form-control">
        </div>
        <div class="form-group">
            <label form="titulo">Descrição</label>
            <textarea class="form-control" name="descricao" rows="5" id="descricao"></textarea>
        </div>
        <div class="form-group">
            <label form="titulo">Estado de Conservação</label>
            <select name="estado" id="estado" class="form-control">
                <option value="1">Ruim</option>
                <option value="2">Bom</option>
                <option value="3">Ótimo</option>
                <option value="4">Novo</option>
            </select>
            <input type="submit" class="btn btn-success" style="cursor: pointer;margin-top: 20px" value="Adicionar">
            <a class="btn btn-default" style="cursor: pointer;margin-top: 20px;background-color: #cccccc" href="<?php echo BASE_URL;?>/home/meusAnuncios">Voltar</a>
        </div>
    </form>
</div>