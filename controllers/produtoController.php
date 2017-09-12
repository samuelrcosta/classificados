<?php
class produtoController extends controller{
    public function abrir($id){
        $dados = array();
        $a = new Anuncios();
        if(isset($id) && !empty($id)){
            $id = addslashes(base64_decode(base64_decode($id)));
        }else{
            header("Location: ".BASE_URL);
        }
        $dados['info'] = $a->getAnuncio($id);
        $dados['titulo'] = 'Detalhes '.$dados['info']['titulo'];
        $this->loadTemplate('produto', $dados);
    }
}