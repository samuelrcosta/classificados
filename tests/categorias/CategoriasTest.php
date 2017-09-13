<?php
declare(strict_types=1);

//http://www.douglaspasqua.com/2015/06/14/testando-banco-de-dados-com-phpunit/
//http://beagile.biz/a-simple-phpunit-xml-configuration-example/

include_once __DIR__.'/../../core/model.php';
include_once __DIR__.'/../../models/Categorias.php';

final class CategoriasTest extends PHPUnit_Extensions_Database_TestCase{

    private $conn = null;
    
    /**
     * @covers Categorias::getLista
    */
    public function testGetLista(){

        $conn = $this->getConnection()->getConnection();

        $GLOBALS['db'] = $conn;

        $categorias = new Categorias();

        $result = $categorias->getLista();
        
        $this->assertCount(1, $result);
        $this->assertEquals('1', $result[0]['id']);
        $this->assertEquals('Categoria Teste', $result[0]['nome']);
        
        $conn = query("DELETE FROM categorias");
        $result2 = $categorias->getLista();
        $this->assertCount(0, $result);
        
    }

    /**
     * @coversNothing
     */
    public function getConnection()
    {
        if(!$this->conn) {

            $db = new PDO('sqlite::classificados:');
            $db->exec('CREATE TABLE `categorias` (`id` int(11) NOT NULL, `nome` varchar(100) NOT NULL)');
            $this->conn =  $this->createDefaultDBConnection($db, ':classificados:');
        }

        return $this->conn;
    }
    
    /**
     * @coversNothing
     */    
    public function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__."/classificados.xml");
    }
}
?>