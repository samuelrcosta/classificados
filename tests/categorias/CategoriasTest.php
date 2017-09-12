<?php
declare(strict_types=1);

include '../../models/Categorias.php';

//http://www.douglaspasqua.com/2015/06/14/testando-banco-de-dados-com-phpunit/



final class CategoriasTest extends PHPUnit_Extensions_Database_TestCase{

    private $conn = null;

    public function testGetLista(){

        $conn = $this->getConnection()->getConnection();

        $GLOBALS['db'] = $conn;

        // realiza operacoes com banco de dados
        // .....

        // verificando o status do banco.
        $query = $conn->query('SELECT * FROM categorias');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1, $results);
        $this->assertEquals('1', $results[0]['id']);
        $this->assertEquals('Categoria Teste', $results[0]['nome']);



        $categorias = new Categorias();

        $result = $categorias->getLista();

        $this->assertCount(1, $result);
        $this->assertEquals('1', $result[0]['id']);
        $this->assertEquals('Categoria Teste', $result[0]['nome']);
    }


    public function getConnection()
    {
        if(!$this->conn) {

            $db = new PDO('sqlite::classificados:');
            $db->exec('CREATE TABLE `categorias` (`id` int(11) NOT NULL, `nome` varchar(100) NOT NULL)');
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