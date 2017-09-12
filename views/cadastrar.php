<div class="container" style="margin-top: 30px;margin-bottom: 30px">
    <h1>Cadastre-se</h1>
    <form method="POST" style="margin-top: 20px" onsubmit="return validar()">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" data-alt="Nome" data-ob="1">
        </div>
        <div class="form-group">
            <label for="nome">E-mail</label>
            <input type="text" name="email" id="email" class="form-control" data-alt="Email" data-ob="1">
        </div>
        <div class="form-group">
            <label for="nome">Senha</label>
            <input type="password" name="senha" id="senha" class="form-control" data-alt="Senha" data-ob="1">
        </div>
        <div class="form-group">
            <label for="nome">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control" data-alt="Telefone" data-ob="1">
        </div>
        <div class="form-group">
            <label for="nome">Celular</label>
            <input type="text" name="celular" id="celular" class="form-control" data-alt="Celular" data-ob="0">
        </div>
        <?php
        if(!empty($aviso)){
            echo $aviso;
        }
        ?>
        <div id='retorno' style='margin-bottom: 15px;margin-top: 5px;display: none' class='alert alert-danger'>
            <ul class="list-group">
                <li class="list-group-item">
                </li>
            </ul>
        </div>
        <input type="submit" value="Cadastrar" class="btn btn-default" style="cursor: pointer" data-alt="Botão" data-ob="0">
    </form>
</div>