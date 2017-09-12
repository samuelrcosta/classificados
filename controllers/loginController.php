<?php
class loginController extends controller {
    public function index(){
        $dados = array();
        $dados['titulo'] = 'Faça o login';
        $dados['aviso'] = '';
        $u = new Usuarios();
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);

            if($u->login($email, $senha)){
                header('Location:'.BASE_URL);
            }else{
                $dados['aviso'] = 'Usuário e/ou senha inválidos.';
            }
        }
        $this->loadTemplate('login', $dados);
    }
    public function logout(){
        unset($_SESSION['cLogin']);
        header('Location:'.BASE_URL);
    }

    public function cadastrar(){
        $dados = array();
        $dados['titulo'] = 'Cadastre-se';
        $dados['aviso'] = '';
        $u = new Usuarios();
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            $telefone = addslashes($_POST['telefone']);
            $celular = addslashes($_POST['celular']);

            if(!empty($nome) && !empty($email) && !empty($senha)){
                if($u->cadastrar($nome, $email, $senha, $telefone, $celular)){
                    $dados['aviso'] =
                    '<div class="alert alert-success">
                        <strong>Parabéns!</strong> Cadastrado com sucesso. <a href="'.BASE_URL.'/login" class="alert-link">Faça o login agora</a>
                    </div>';
                }else{
                    $dados['aviso'] =
                    '<div class="alert alert-warning">
                        Este usuário já existe / Dados incorretos. <a href="'.BASE_URL.'/login" class="alert-link">Faça o login agora</a>
                    </div>';
                }
            }else{
                $dados['aviso'] =
                '<div class="alert alert-warning">
                    Preencha todos os campos!
                </div>';
            }
        }
        $this->loadTemplate('cadastrar', $dados);
    }
}