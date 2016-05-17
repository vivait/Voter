<?php
namespace Vivait\Voter\Dispatcher;

use Symfony\Component\EventDispatcher\Event;

interface ActionDispatcherInterface
{
    /**
     * @return void
     */
    public function performFromEvent(Event $event, $eventName);

    /**
     * @return void
     */
    public function perform($entity);

    /**
     * @return string
     */
    public function getName();
    public function setName($name);
}
