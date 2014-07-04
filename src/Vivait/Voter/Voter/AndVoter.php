<?php

namespace Vivait\Voter\Voter;

class AndVoter extends VoterAbstract
{
    public function result($entity)
    {
        foreach ($this->conditions as $condition) {
            $result = $condition->result($entity);
            $this->logger->debug(sprintf('Condition "%s" returned result: %s', (string)$condition, $result ? 'true' : 'false'));

            if ($result == false) {
                return false;
            }
        }

        return true;
    }

    public function supports($entities)
    {
        if (!is_array($entities)) {
            $entities = [$entities];
        }

        foreach ($this->conditions as $condition) {
            if (array_diff((array)$condition->requires(), $entities)) {
                return false;
            }
        }

        return true;
    }
} 