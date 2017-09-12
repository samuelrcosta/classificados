<?php
class homeController extends controller{
    public function index($p = 1){
        $a = new Anuncios();
        $u = new Usuarios();
        $c = new Categorias();
        $filtros = array(
            'categoria' => '',
            'preço' => '',
            'estado' => '',
        );
        if(isset($_GET['filtros'])){
            $filtros = $_GET['filtros'];
        }
        $total_anuncios = $a->getTotalAnuncios($filtros);
        $total_usuarios = $u->getTotalUsuarios();

        $max_pagina = 4;
        $total_paginas = ceil($total_anuncios/$max_pagina);
        $anuncios = $a->getUltimosAnuncios($p, $max_pagina, $filtros);
        $categorias = $c->getLista();
        $dados = array(
            'titulo' => 'Classificados',
            'total_anuncios' => $total_anuncios,
            'total_usuarios' => $total_usuarios,
            'categorias' => $categorias,
            'total_paginas' => $total_paginas,
            'anuncios' => $anuncios,
            'filtros' => $filtros,
        );
        $this->loadTemplate('home', $dados);
    }


    public function meusAnuncios(){
        $dados = array();
        if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])){
            header("Location: ".BASE_URL);
        }
        $a = new Anuncios();
        $dados['titulo'] = 'Meus Anúncios';
        $dados['anuncios'] = $a->getMeusAnuncios(addslashes($_SESSION['cLogin']));
        $this->loadTemplate('meusAnuncios', $dados);
    }

    public function addAnuncio(){
        $dados = array();
        $a = new Anuncios();
        $dados['titulo'] = 'Criando novo Anúncio';
        if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])){
            header("Location: ".BASE_URL);
        }
        if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
            $titulo = addslashes($_POST['titulo']);
            $categoria = addslashes($_POST['categoria']);
            $valor = addslashes($_POST['valor']);
            $descricao = addslashes($_POST['descricao']);
            $estado = addslashes($_POST['estado']);

            $a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);
            header("Location: ".BASE_URL."/home/meusAnuncios");
        }
        $c = new Categorias();
        $dados['cats'] = $c->getLista();
        $this->loadTemplate('addAnuncios', $dados);
        echo "<script type='text/javascript' src='".BASE_URL."/assets/js/jquery.mask.js'></script>";
    }

    public function editarAnuncio($id){
        $dados = array();
        $a = new Anuncios();
        $dados['id'] = addslashes($id);
        $dados['titulo'] = 'Editando Anúncio';
        if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])){
            header("Location: ".BASE_URL."/login");
        }
        if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
            $titulo = addslashes($_POST['titulo']);
            $categoria = addslashes($_POST['categoria']);
            $valor = addslashes($_POST['valor']);
            $descricao = addslashes($_POST['descricao']);
            $estado = addslashes($_POST['estado']);
            $id = base64_decode(base64_decode(addslashes($id)));


            $a->editarAnuncio($titulo, $categoria, $valor, $descricao, $estado, $id);
            header("Location: ".BASE_URL."/home/meusAnuncios");
        }
        if(isset($id) && !empty($id)){
            $dados['info']= $a->getAnuncio(base64_decode(base64_decode(addslashes($id))));
        }else{
            header("Location: ".BASE_URL."/login");
        }
        $c = new Categorias();
        $dados['cats'] = $c->getLista();
        $this->loadTemplate('editarAnuncios', $dados);
        echo "<script type='text/javascript' src='".BASE_URL."/assets/js/jquery.mask.js'></script>";
    }
    public function salvarFoto(){
        $a = new Anuncios();
        $a->salvarFoto();
    }

    public function excluirFoto($id){
        if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])){
            header("Location: ".BASE_URL."/login");
            exit;
        }
        $id_anuncio = new Anuncios();
        if(isset($id) && !empty($id)){
            $id_anuncio = $id_anuncio->excluirFoto(base64_decode(base64_decode(addslashes($id))));
        }

        if(isset($id_anuncio)){
            header ("Location: ".BASE_URL."/home/editarAnuncio/".base64_encode(base64_encode($id_anuncio))."");
        }else{
            header("Location: ".BASE_URL."home/meusAnuncios");
        }
    }

    public function excluirAnuncio($id){
        if(!isset($_SESSION['cLogin']) || empty($_SESSION['cLogin'])){
            header("Location: ".BASE_URL."/login");
            exit;
        }
        $a = new Anuncios();
        if(isset($id) && !empty($id)){
            $a->excluirAnuncio(base64_decode(base64_decode(addslashes($id))));
        }
        header("Location: ".BASE_URL."/home/meusAnuncios");
    }
}