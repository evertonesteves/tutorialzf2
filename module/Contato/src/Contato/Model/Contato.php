<?php
namespace Contato\Model;

use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;
class Contato implements InputFilterAwareInterface
{
    public $id;
    public $nome;
    public $telefone_principal;
    public $telefone_secundario;
    public $createdAt;
    public $updateAt;
    protected $inputFilter;


    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : NULL;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : NULL;
        $this->telefone_principal = (!empty($data['telefone_principal'])) ? $data['telefone_principal'] : NULL;
        $this->telefone_secundario = (!empty($data['telefone_secundario'])) ? $data['telefone_secundario'] : NULL;
        $this->createdAt = (!empty($data['createdAt'])) ? $data['createdAt'] : NULL;
        $this->updateAt = (!empty($data['updateAt'])) ? $data['updateAt'] : NULL;
    }

    public function getInputFilter() 
    {
        if (!$this->inputFilter) 
        {
            $inputFilter = new InputFilter();

            // input filter para campo de id
            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'), # transforma string para inteiro
                ),
            ));

            // input filter para campo de nome  
            $inputFilter->add(array(
                'name' => 'nome',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), # remove xml e html da string
                    array('name' => 'StringTrim'), # remove espacos do início e do final da string
                    array('name' => 'StringToUpper'), # transforma string para maiusculo
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 100,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mínimo de caracteres aceitáveis %min%.',
                                \Zend\Validator\StringLength::TOO_LONG => 'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));

            // input filter para campo de telefone principal
            $inputFilter->add(array(
                'name' => 'telefone_principal',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'), # remove xml e html da string
                    array('name' => 'StringTrim'), # remove espacos do início e do final da string
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
                            ),
                        ),
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8, #xxxxxxxx
                            'max' => 15, #(xxx)xxxx-xxxxx
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mínimo de caracteres aceitáveis %min%.',
                                \Zend\Validator\StringLength::TOO_LONG => 'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));

            // input filter para campo telefone secundário
            $inputFilter->add(array(
                'name' => 'telefone_secundario',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'), # remove xml e html da string
                    array('name' => 'StringTrim'), # remove espacos do início e do final da string
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8, #xxxxxxxx
                            'max' => 15, #(xxx)xxxx-xxxxx
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Mínimo de caracteres aceitáveis %min%.',
                                \Zend\Validator\StringLength::TOO_LONG => 'Máximo de caracteres aceitáveis %max%.',
                            ),
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
        
    }

    /**
    * Método obrigatório de implementação da interface InputFilterAwareInterface, 
    * não utilizaremos esse método para nada, logo lançamos uma exception em 
    * casa de uso deste
    * 
    * @param Zend\InputFilter\InputFilterInterface $inputFilter
    * @throws Exception
    */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception('Não utilizado.');
    }

}
