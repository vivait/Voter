<?php

namespace Vivait\Voter\Voter;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Vivait\Voter\Model\ConditionInterface;
use Vivait\Voter\Model\VoterInterface;

abstract class VoterAbstract implements VoterInterface {

    /**
     * @var \SplObjectStorage|\Vivait\Voter\Model\ConditionInterface[]
     */
    protected $conditions;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(array $conditions = array(), LoggerInterface $logger = null)
    {
        $this->conditions = new \SplObjectStorage();
        $this->addConditions($conditions);

        if (!$logger) {
            $logger = new NullLogger();
        }

        $this->logger = $logger;
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
     * @param ConditionInterface $condition
     * @return $this
     */
    public function addCondition(ConditionInterface $condition)
    {
        $this->conditions->attach($condition, $condition->requires());

        return $this;
    }

    /**
     * @return \SplObjectStorage|\Vivait\Voter\Model\ConditionInterface[]
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param ConditionInterface $condition
     * @return $this
     */
    public function removeCondition(ConditionInterface $condition)
    {
        $this->conditions->detach($condition);

        return $this;
    }

}
