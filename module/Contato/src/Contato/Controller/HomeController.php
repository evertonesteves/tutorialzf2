<?php
/**
 * namespace de localização do controller
 */
namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter as DbAdapter;

class HomeController extends AbstractActionController
{
    /**
     * action index
     * @return Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $myVarDump = function($nome_linha = "Nome da Linha", $data = NULL, $caracter = '-')
        {
            echo str_repeat($caracter, 100) . '<br />' . ucwords($nome_linha) . '<pre><br />';
            var_dump($data);
            echo '</pre>' . str_repeat($caracter, 100) . '<br /><br />';
        };
        $adapter = $this->getServiceLocator()->get('AdapterDb');
        $myVarDump('Nome Schema', $adapter->getCurrentSchema());
        $myVarDump('Quantidades elementos tabela contatos',
            $adapter->query("SELECT * FROM contatos")->execute()->count());
        /**
        * montar objeto sql e executar
        */
       $sql        = new \Zend\Db\Sql\Sql($adapter);
       $select     = $sql->select()->from('contatos');
       $statement  = $sql->prepareStatementForSqlObject($select);
       $resultsSql = $statement->execute();
       $myVarDump(
               "Objet Sql com Select executado",
               $resultsSql
       );

       /**
        * motar objeto resultset com objeto sql e mostrar resultado em array
        */
       $resultSet = new \Zend\Db\ResultSet\ResultSet;
       $resultSet->initialize($resultsSql);
       $myVarDump(
               "Resultado do Objeto Sql para Array ",
               $resultSet->toArray()
       );
       die();
       //return new ViewModel();
    }
    
    /**
     * action sobre
     * @return Zend\View\Model\ViewModel
     */
    public function sobreAction()
    {
        return new ViewModel();
    }


}

