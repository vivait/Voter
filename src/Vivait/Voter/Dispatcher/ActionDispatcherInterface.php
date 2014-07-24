<?php
namespace Vivait\Voter\Dispatcher;

use Vivait\Voter\Model\EntityEvent;

interface ActionDispatcherInterface
{
    public function performFromEvent(EntityEvent $event, $eventName);

    public function perform($entity);

    public function getName();
    public function setName($name);
}