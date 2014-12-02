<?php

namespace Contato\Model;

use Zend\Db\TableGateway\TableGateway;

class ContatoTable 
{
    protected $tableGateway;
    /**
     * Contrutor com dependências do Adapter do BD
     * 
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway) 
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * 
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }


    /**
     * 
     * @param integer $id
     * @return ModelContato
     * @throws Exception
     */
    public function find($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row)
        {
            throw new Exception("Não foi encontrado contato de id = {$id}");
        }
        return $row;
    }
}
