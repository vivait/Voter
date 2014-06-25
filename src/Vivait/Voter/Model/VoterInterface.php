<?php

namespace Vivait\Voter\Model;

use Vivait\Voter\Model\ConditionInterface;
use Vivait\Voter\Voter\VoterAbstract;

interface VoterInterface {
    /**
     * @param array $conditions
     */
    function __construct(array $conditions = array());

    /**
     * @param $entities
     * @return mixed
     */
    public function supports($entities);

    /**
     * @param $entity
     * @return mixed
     */
    public function result($entity);

    /**
     * @param array $conditions
     * @return $this
     */
    public function addConditions(array $conditions);

    /**
     * @param \Vivait\Voter\Voter\ConditionInterface $condition
     * @return $this
     */
    public function addCondition(\Vivait\Voter\Model\ConditionInterface $condition);

    /**
     * @return \SplObjectStorage|\Vivait\Voter\Voter\ConditionInterface[]
     */
    public function getConditions();

    /**
     * @param \Vivait\Voter\Voter\ConditionInterface $condition
     * @return $this
     */
    public function removeCondition(\Vivait\Voter\Model\ConditionInterface $condition);
}