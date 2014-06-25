<?php

namespace Vivait\Voter;

use Vivait\Voter\Model\ConditionInterface;
use Vivait\Voter\Model\VoterInterface;

abstract class VoterAbstract implements VoterInterface {

    /**
     * @var \SplObjectStorage|\Vivait\Inspector\Model\\Vivait\Voter\Model\ConditionInterface[]
     */
    protected $conditions;

    function __construct(array $conditions = array())
    {
        $this->conditions = new \SplObjectStorage();
        $this->addConditions($conditions);
    }

    /**
     * @param array $conditions
     * @return $this
     */
    public function addConditions(array $conditions)
    {
        foreach ($conditions as $condition) {
            $this->addCondition($condition);
        }

        return $this;
    }

    /**
     * @param \Vivait\Inspector\Model\\Vivait\Voter\Model\ConditionInterface $condition
     * @return $this
     */
    public function addCondition(Model\ConditionInterface $condition)
    {
        $this->conditions->attach($condition, $condition->requires());

        return $this;
    }

    /**
     * @return \SplObjectStorage|\Vivait\Inspector\Model\ConditionInterface[]
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param \Vivait\Inspector\Model\\Vivait\Voter\Model\ConditionInterface $condition
     * @return $this
     */
    public function removeCondition(ConditionInterface $condition)
    {
        $this->conditions->detach($condition);

        return $this;
    }


}