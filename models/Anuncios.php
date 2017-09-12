<?php
class Anuncios extends model{

    public function getTotalAnuncios($filtros){
        $filtrostring = array('1=1');
        if(!empty($filtros['categoria'])){
            $filtrostring[] = 'anuncios.id_categoria = :id_categoria';
        }
        if(!empty($filtros['preço'])){
            $filtrostring[] = 'anuncios.valor BETWEEN :valor1 AND :valor2';
        }
        if(!empty($filtros['estado'])){
            $filtrostring[] = 'anuncios.estado = :estado';
        }
        $sql = $this->db->prepare("SELECT COUNT(*) as c FROM anuncios WHERE ".implode(' AND ', $filtrostring));
        if(!empty($filtros['categoria'])){
            $sql->bindValue(":id_categoria", $filtros['categoria']);
        }
        if(!empty($filtros['preço'])){
            $preco = explode("-", $filtros['preço']);
            $sql->bindValue(":valor1", $preco[0]);
            $sql->bindValue(":valor2", $preco[1]);
        }
        if(!empty($filtros['estado'])){
            $sql->bindValue(":estado", $filtros['estado']);
        }
        $sql->execute();
        $row = $sql->fetch();
        return $row['c'];
    }

    public function getMeusAnuncios($id_usuario){
        $array = array();
        $sql = $this->db->prepare("SELECT *, (SELECT anuncios_imagens.url FROM anuncios_imagens WHERE anuncios_imagens.id_anuncios = anuncios.id limit 1) as url FROM anuncios WHERE id_usuario = ?");
        $sql->execute(array($id_usuario));
        $array = $sql->fetchAll();
        if($array && count($array)){
            return $array;
        }else{
            $array = array();
            return $array;
        }
    }

    public function getUltimosAnuncios($page, $max, $filtros){
        $offset = ($page - 1) * $max;
        $array = array();

        $filtrostring = array('1=1');
        if(!empty($filtros['categoria'])){
            $filtrostring[] = 'anuncios.id_categoria = :id_categoria';
        }
        if(!empty($filtros['preço'])){
            $filtrostring[] = 'anuncios.valor BETWEEN :valor1 AND :valor2';
        }
        if(!empty($filtros['estado'])){
            $filtrostring[] = 'anuncios.estado = :estado';
        }

        $sql = $this->db->prepare("SELECT *, (SELECT anuncios_imagens.url FROM anuncios_imagens WHERE anuncios_imagens.id_anuncios = anuncios.id limit 1) as url, (SELECT categorias.nome FROM categorias WHERE categorias.id = anuncios.id_categoria limit 1) as categoria FROM anuncios WHERE ".implode(' AND ', $filtrostring)." ORDER BY id DESC LIMIT ".$offset.", ".$max);

        if(!empty($filtros['categoria'])){
            $sql->bindValue(":id_categoria", $filtros['categoria']);
        }
        if(!empty($filtros['preço'])){
            $preco = explode("-", $filtros['preço']);
            $sql->bindValue(":valor1", $preco[0]);
            $sql->bindValue(":valor2", $preco[1]);
        }
        if(!empty($filtros['estado'])){
            $sql->bindValue(":estado", $filtros['estado']);
        }

        $sql->execute();

        if($sql ->rowCount() > 0 ){
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado){
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $sql = $this->db->prepare("INSERT INTO anuncios SET titulo = ?, id_categoria = ?, id_usuario = ?, descricao = ?, valor = ?, estado = ?, status = 0");
        $sql->execute(array($titulo, $categoria, $_SESSION['cLogin'], $descricao, $valor, $estado));

    }

    public function editarAnuncio($titulo, $categoria, $valor, $descricao, $estado, $id){
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $sql = $this->db->prepare("UPDATE anuncios SET titulo = ?, id_categoria = ?, id_usuario = ?, descricao = ?, valor = ?, estado = ?, status = 0 WHERE id = ?");
        $sql->execute(array($titulo, $categoria, $_SESSION['cLogin'], $descricao, $valor, $estado, $id));
        /* -- MODO ANTIGO DE ENVIO DE FOTOS - PROCESSAMENTO FEITO PELO SERVIDOR ------
        if(count($fotos) > 0){
            for($q = 0;$q < count($fotos['tmp_name']);$q++){
                $tipo = $fotos['type'][$q];
                if(in_array($tipo, array('image/jpeg', 'image/png'))){

                    $tmp_name = md5(time().rand(0,9999));
                    $tmp_name = $tmp_name.".jpg";
                    move_uploaded_file($fotos['tmp_name'][$q], 'assets/imgs/anuncios/'.$tmp_name);
                    list($width_orig, $height_orig) = getimagesize('assets/imgs/anuncios/'.$tmp_name);
                    $ratio = $width_orig/$height_orig;
                    $width = 500;
                    $height = 500;

                    if($width/$height > $ratio){
                        $width = $height*$ratio;
                    }else{
                        $height = $width/$ratio;
                    }
                    $img = imagecreatetruecolor($width, $height);
                    if($tipo = 'image/jpeg'){
                        $origi = imagecreatefromjpeg('assets/imgs/anuncios/'.$tmp_name);
                    }elseif($tipo = 'image/png'){
                        $origi = imagecreatefrompng('assets/imgs/anuncios/'.$tmp_name);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagejpeg($img, 'assets/imgs/anuncios/'.$tmp_name, 80);

                    $sql = $this->db->prepare("INSERT INTO anuncios_imagens SET id_anuncios = ?, url = ?");
                    $sql->execute(array($id, $tmp_name));
                }
            }
        }
        */

    }

    public function excluirAnuncio($id){
        $sql = $this->db->prepare("DELETE FROM anuncios_imagens WHERE id_anuncios = ?");
        $sql->execute(array($id));
        $sql = $this->db->prepare("DELETE FROM anuncios WHERE id = ?");
        $sql->execute(array($id));
    }

    public function getAnuncio($id){
        $array = array();
        $array['fotos'] = array();
        $sql = $this->db->prepare("SELECT 
*, 
(SELECT categorias.nome FROM categorias WHERE categorias.id = anuncios.id_categoria limit 1) as categoria, 
(SELECT usuarios.nome FROM usuarios WHERE usuarios.id = anuncios.id_usuario limit 1) as nome, 
(SELECT usuarios.telefone FROM usuarios WHERE usuarios.id = anuncios.id_usuario limit 1) as telefone, 
(SELECT usuarios.celular FROM usuarios WHERE usuarios.id = anuncios.id_usuario limit 1) as celular 
                              FROM anuncios WHERE id = ?");
        $sql->execute(array($id));
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            $sql = $this->db->prepare("SELECT id, url FROM anuncios_imagens WHERE id_anuncios = ?");
            $sql->execute(array($id));
            if($sql->rowCount() > 0){
                $array['fotos'] = $sql->fetchAll();
            }
        }
        return $array;
    }

    public function excluirFoto($id){
        $id_anuncio = 0;
        $sql = $this->db->prepare("SELECT * FROM anuncios_imagens WHERE id = ?");
        $sql->execute(array($id));
        if($sql->rowCount() > 0){
            $row = $sql->fetch();
            $id_anuncio = $row['id_anuncios'];
            unlink("assets/imgs/anuncios/".$row['url']);
        }

        $sql = $this->db->prepare("DELETE FROM anuncios_imagens WHERE id = ?");
        $sql->execute(array($id));

        return $id_anuncio;
    }

    public function salvarFoto(){
// Recuperando imagem em base64
// Exemplo: data:image/png;base64,AAAFBfj42Pj4
        $imagem = $_POST['imagem'];
        $id = addslashes($_POST['id']);

// Separando tipo dos dados da imagem
// $tipo: data:image/png
// $dados: base64,AAAFBfj42Pj4
        list($tipo, $dados) = explode(';', $imagem);

// Isolando apenas o tipo da imagem
// $tipo: image/png
        list(, $tipo) = explode(':', $tipo);

// Isolando apenas os dados da imagem
// $dados: AAAFBfj42Pj4
        list(, $dados) = explode(',', $dados);

// Convertendo base64 para imagem
        $dados = base64_decode($dados);

// Gerando nome aleatório para a imagem
        $nome = md5(time().rand(0,9999));
        $nome_bd = $nome.".jpg";

        $sql = $this->db->prepare("INSERT INTO anuncios_imagens SET id_anuncios = ?, url = ?");
        $sql->execute(array($id, $nome_bd));

// Salvando imagem em disco
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/php/classificados_mvc/assets/imgs/anuncios/'.$nome.'.jpg', $dados);

        echo "1";
    }
}