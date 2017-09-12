<div class="container" style="margin-top: 30px;margin-bottom: 30px">
        <h1>Fazer Login</h1>
<form method="POST" style="margin-top: 20px">
    <div class="form-group">
        <label for="nome">E-mail</label>
        <input type="text" name="email" id="email" class="form-control">
    </div>
    <div class="form-group">
        <label for="nome">Senha</label>
        <input type="password" name="senha" id="senha" class="form-control">
    </div>
    <?php
    if(!empty($aviso)){
        echo "<div class='alert alert-danger'>".$aviso."</div>";
    }
    ?>
    <input type="submit" value="Entrar" class="btn btn-default" style="cursor: pointer">
</form>
</div>