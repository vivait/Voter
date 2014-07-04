<?php

namespace Vivait\Voter\Model;

interface ConditionInterface {
    /**
     * @return mixed
     */
    public function requires();

    /**
     * @param mixed $entities
     * @return boolean
     */
    public function result($entities);

    /**
     * @return string
     */
    public function __toString();
}