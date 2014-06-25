<?php

namespace Vivait\Voter\Dispatcher;

use Vivait\Voter\Model\ActionInterface;
use Vivait\Voter\Model\VoterInterface;

class ActionDispatcher
{
    /**
     * @var VoterInterface
     */
    private $voter;

    /**
     * @var \SplObjectStorage|ActionInterface[]
     */
    private $actions;

    public function __construct(VoterInterface $voter, array $actions = array())
    {
        $this->voter   = $voter;
        $this->actions = new \SplObjectStorage();

        $this->addActions($actions);
    }

    public function perform($entity)
    {
        if ($this->voter->result($entity)) {
            $this->performActions($entity);
        }
    }

    /**
     * @param array $actions
     * @return $this
     */
    public function addActions(array $actions)
    {
        foreach ($actions as $action) {
            $this->addAction($action);
        }

        return $this;
    }

    /**
     * @param ActionInterface $action
     * @return $this
     */
    public function addAction(ActionInterface $action)
    {
        $this->actions->attach($action, $action->requires());

        return $this;
    }

    /**
     * @return \SplObjectStorage|ActionInterface[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param ActionInterface $action
     * @return $this
     */
    public function removeAction(ActionInterface $action)
    {
        $this->actions->detach($action);

        return $this;
    }

    /**
     * @param $entity
     * @return bool
     */
    private function performActions($entity)
    {
        foreach ($this->actions as $action) {
            if ($action->perform($entity) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets voter
     * @return VoterInterface
     */
    public function getVoter()
    {
        return $this->voter;
    }

    /**
     * Sets voter
     * @param \Vivait\Voter\Model\VoterInterface $voter
     * @return $this
     */
    public function setVoter($voter)
    {
        $this->voter = $voter;

        return $this;
    }
}