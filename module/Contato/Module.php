<?php
namespace Contato;

// import ModelContato
use Contato\Model\Contato,
    Contato\Model\ContatoTable;

// import ZendDb
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    /**
     * Register View Helper
     */
    public function getViewHelperConfig()
    {
        return array(
            # Registrar View Helper com injeção de dependência
            'factories' => array(
                'menuAtivo' => function($sm)
                {
                    return new View\Helper\MenuAtivo($sm->getServiceLocator()->get('Request'));
                },
                'message' => function($sm)
                {
                    return new View\Helper\Message($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger'));
                }
            ),
            'invokables' => array(
                'filter' => 'Contato\View\Helper\ContatoFilter'
            )
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ContatoTableGateway' => function ($sm)
                {
                    //Obtendo o Adapter através do ServiceManager
                    $adapter = $sm->get('\Zend\Db\Adapter\Adapter');
                    //Configura ResultSet com o Model Contato
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Contato());
                    //Retorna TabbleGateway configurado para o Model Contato
                    return new TableGateway('contatos', $adapter, NULL, $resultSetPrototype);
                },
                'ModelContato' => function($sm)
                {
                    //Retorna a instância do Model ContatoTable
                    return new ContatoTable($sm->get('ContatoTableGateway'));
                }
            )
        );
    }
}
