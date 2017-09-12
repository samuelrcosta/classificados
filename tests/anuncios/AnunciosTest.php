<?php
declare(strict_types=1);

//http://www.douglaspasqua.com/2015/06/14/testando-banco-de-dados-com-phpunit/

include_once __DIR__.'/../../core/model.php';
include_once __DIR__.'/../../models/Anuncios.php';

final class AnunciosTest extends PHPUnit_Extensions_Database_TestCase{

    private $conn = null;

    public function testGetMeusAnuncios(){

        $conn = $this->getConnection()->getConnection();

        $GLOBALS['db'] = $conn;

        $query = $conn->query('SELECT * FROM categorias');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1, $results);
        $this->assertEquals('1', $results[0]['id']);
        $this->assertEquals('Categoria Teste', $results[0]['nome']);

        $a = new Anuncios();

        $result = $a->getMeusAnuncios(1);

        $this->assertCount(1, $result);
        $this->assertEquals('anuncio2', $result[0]['url']);
        $this->assertEquals('2', $result[0]['id']);
        $this->assertEquals('1', $result[0]['id_usuario']);
    }


    public function getConnection()
    {
        if(!$this->conn) {

            $db = new PDO('sqlite::classificados:');
            $db->exec('CREATE TABLE `anuncios_imagens` (`id` int(11) NOT NULL, `url` varchar(100) NOT NULL, `id_anuncios` int(11) NOT NULL');
            $db->exec('CREATE TABLE `anuncios` (`id` int(11) NOT NULL, `id_usuario` int(11) NOT NULL');
            $this->conn =  $this->createDefaultDBConnection($db, ':classificados:');
        }

        return $this->conn;
    }

    public function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__."/classificados.xml");
    }
}
?>