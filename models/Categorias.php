<?php
class Categorias extends model{
    public function getLista(){
        $array = array();
        $sql = $this->db->query("SELECT * FROM categorias");
        $sql = $sql->fetchAll();
        if($sql && count($sql)){
            return $sql;
        }
        return $array;
    }
}
?>