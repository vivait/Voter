<?php

namespace Vivait\Voter\Dispatcher;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
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

    /**
     * @var LoggerInterface
     */
    private $logger;

    private $name;

    public function __construct($name, VoterInterface $voter, array $actions = array(), LoggerInterface $logger = null)
    {
        $this->voter = $voter;
        $this->actions = new \SplObjectStorage();

        $this->addActions($actions);

        if (!$logger) {
            $logger = new NullLogger();
        }

        $this->logger = $logger;
    }

    public function perform($entity)
    {
        $entity_map = (is_array($entity)) ?
          array_map(
            function ($obj) {
                return get_class($obj);
            },
            $entity
          ) : [
            get_class($entity)
          ];

        if (!$this->voter->supports($entity_map)) {
            throw new \RuntimeException(
              sprintf('Inspection "%s" with voter "%s" does not support entities: %s', $this->name, get_class($this->voter), implode(', ', $entity_map))
            );
        }

        $result = $this->voter->result($entity);
        $this->logger->debug(
          sprintf('Inspection "%s" with voter "%s" returned result: %s', $this->name, get_class($this->voter), $result ? 'true' : 'false')
        );

        if ($result) {
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
            $result = $action->perform($entity);

            $this->logger->info(
              sprintf('Performing action "%s" with result: %s', get_class($action), $result ? 'true' : 'false')
            );

            if ($result === false) {
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

    /**
     * Gets logger
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Sets logger
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }
}