<?php
namespace Vivait\Voter\Dispatcher;

use Symfony\Component\EventDispatcher\Event;
use Vivait\Voter\Model\EntityEvent;

interface ActionDispatcherInterface
{
    public function performFromEvent(Event $event, $eventName);

    public function perform($entity);

    public function getName();
    public function setName($name);
}