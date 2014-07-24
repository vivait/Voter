<?php

namespace Vivait\Voter\Model;

interface EntityEvent {
    /**
     * Provides the entities used in the event,
     * ready to be used by the inspection
     * @return array
     */
    public function getEntities();

//    public static function providesEntities();

    /**
     * Provides an associative array of event name => event label
     * for us when building an inspection
     * @return array
     */
    public static function supportsEvents();
} 