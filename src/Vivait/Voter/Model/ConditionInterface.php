<?php

namespace Vivait\Voter\Model;

interface ConditionInterface {
    /**
     * @return mixed
     */
    public function requires();

    /**
     * @param mixed $entity
     * @return boolean
     */
    public function result($entity);
}