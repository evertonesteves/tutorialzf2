<?php
namespace Contato\Model;

class Contato 
{
    public $id;
    public $nome;
    public $telefone_principal;
    public $telefone_secundario;
    public $createdAt;
    public $updateAt;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : NULL;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : NULL;
        $this->telefone_principal = (!empty($data['telefone_principal'])) ? $data['telefone_principal'] : NULL;
        $this->telefone_secundario = (!empty($data['telefone_secundario'])) ? $data['telefone_secundario'] : NULL;
        $this->createdAt = (!empty($data['createdAt'])) ? $data['createdAt'] : NULL;
        $this->updateAt = (!empty($data['updateAt'])) ? $data['updateAt'] : NULL;
    }
}
