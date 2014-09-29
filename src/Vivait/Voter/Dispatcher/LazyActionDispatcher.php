<?php

namespace Vivait\Voter\Dispatcher;

use Symfony\Component\EventDispatcher\Event;
use Vivait\InspectorBundle\Model\ActionDispatcherFactory;

class LazyActionDispatcher implements ActionDispatcherInterface
{
    /**
     * @var ActionDispatcherFactory
     */
    private $actionDispatcherFactory;

    /**
     * @var string
     */
    private $inspectionId;

    /**
     * @var string
     */
    private $inspectionName;

    public function __construct($inspectionId, $inspectionName, ActionDispatcherFactory $actionDispatcherFactory)
    {
        $this->actionDispatcherFactory = $actionDispatcherFactory;
        $this->inspectionId = $inspectionId;
        $this->inspectionName = $inspectionName;
    }

    public function perform($entity)
    {
        $actionDispatcher = $this->actionDispatcherFactory->create($this->inspectionId);
        $actionDispatcher->perform($entity);
    }

    public function performFromEvent(Event $event, $eventName)
    {
        $actionDispatcher = $this->actionDispatcherFactory->create($this->inspectionId);
        $actionDispatcher->performFromEvent($event, $eventName);
    }

    /**
     * Gets inspectionName
     * @return string
     */
    public function getName()
    {
        return $this->inspectionName;
    }

    /**
     * Sets inspectionName
     * @param string $inspectionName
     * @return $this
     */
    public function setName($inspectionName)
    {
        $this->inspectionName = $inspectionName;

        return $this;
    }

    /**
     * Gets inspectionId
     * @return string
     */
    public function getInspectionId()
    {
        return $this->inspectionId;
    }

    /**
     * Sets inspectionId
     * @param string $inspectionId
     * @return $this
     */
    public function setInspectionId($inspectionId)
    {
        $this->inspectionId = $inspectionId;

        return $this;
    }
}
