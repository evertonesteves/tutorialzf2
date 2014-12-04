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
    
    /**
    * Inserir um novo contato
    * 
    * @param ContatoModelContato $contato
    * @return 1/0
    */
    public function save(Contato $contato)
    {
        $timeNow = new \DateTime();

        $data = [
            'nome'                  => $contato->nome,
            'telefone_principal'    => $contato->telefone_principal,
            'telefone_secundario'   => $contato->telefone_secundario,
            'createdAt'             => $timeNow->format('Y-m-d H:i:s'), 
            'updateAt'              => $timeNow->format('Y-m-d H:i:s'), # data de criação igual a de atualização 
        ];

        return $this->tableGateway->insert($data);
    }
    
    /**
    * Atualizar um contato existente
    * 
    * @param ContatoModelContato $contato
    * @throws Exception
    */
    public function update(Contato $contato)
    {
        $timeNow = new \DateTime();

        $data = [
           'nome'                  => $contato->nome,
           'telefone_principal'    => $contato->telefone_principal,
           'telefone_secundario'   => $contato->telefone_secundario, 
           'updateAt'              => $timeNow->format('Y-m-d H:i:s'),
         ];

        $id = (int) $contato->id;
        if ($this->find($id)) 
        {
            $this->tableGateway->update($data, array('id' => $id));
        } 
        else 
        {
            throw new Exception("Contato #{$id} inexistente");
        }
    }
    
    /**
    * Deletar um contato existente
    * 
    * @param type $id
    */
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}
