<?php
namespace Product\Controller\Cli;

use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;

class MenuController extends AbstractActionController
{
    public function indexAction()
    {
        $data = "available action\ninit-database";
        return $data;
    }

    public function initDatabaseAction()
    {
        $dbAdapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $dbAdapter->query($this->tableProduct(), Adapter::QUERY_MODE_EXECUTE);
        return "finish initializing database";
    }

    public function tableProduct()
    {
        $query = "CREATE TABLE IF NOT EXISTS `table_product` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `category` varchar(256) NOT NULL,
                  PRIMARY KEY (`id`),
                  KEY `name` (`name`,`category`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
        return $query;
    }
}