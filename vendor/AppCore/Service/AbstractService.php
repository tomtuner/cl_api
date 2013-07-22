<?php

/**
 * Description of AbstractService
 *
 * @author Nikesh Hajari
 */

namespace AppCore\Service;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

abstract class AbstractService implements EventManagerAwareInterface
{

    /**
     * Zend EventManager
     * @var \Zend\EventManager\EventManager 
     */
    protected $eventManager;
    
    /**
     * Collection of Models
     * @var array 
     */
    private $models;
    
    /**
     * Collection of Data Entities
     * @var array 
     */
    private $dataEntities;
    
    /**
     * Service Default Constructor
     * @param \AppCore\Service\Entity\iServiceEntity;  $serviceEntity
     */
    public function __construct()
    {
        $this->models = array();
        $this->dataEntities = array();
    }

    /**
     * Set Event Manager
     * 
     * @param EventManagerInterface $eventManager
     * @return \AppCore\Service\AbstractService 
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Get Event Manager
     * 
     * @return \Zend\EventManager\EventManager 
     */
    public function getEventManager()
    {
        //check to see if event manager exists
        if(null === $this->eventManager)
        {
            $this->setEventManager(new EventManager());
        }
        return $this->eventManager;
    }

    /**
     * @todo Add SharedEventManagerCollection - 
     * To support cross cutting application features
     */
    
    /**
     * Add Model
     * @param type $model
     * @return void
     */
    public function addModel($model)
    {
        $this->models[get_class($model)] = $model;
    }
    
    /**
     * Get Model
     * @param string $modelClassName
     * @return object
     */
    public function getModel($modelClassName)
    {
        return $this->models[$modelClassName];
    }
    
    /**
     * Add Data Entity
     * @param type $dataEntity
     */
    public function addDataEntity($dataEntity)
    {
        $this->dataEntities[get_class($dataEntity)] = $dataEntity;
    }
    
    /**
     * Get Data Entity
     * @param type $dataEntityClassName
     * @return object
     */
    public function getDataEntity($dataEntityClassName)
    {
        return $this->dataEntities[$dataEntityClassName];
    }
    
}

?>
