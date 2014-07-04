<?php

namespace Vivait\Voter\Voter;

class OrVoter extends VoterAbstract {
    public function result($entity) {
        foreach ($this->conditions as $condition) {
            $result = $condition->result($entity);

            $this->logger->debug(sprintf('Condition "%s" returned result: %s', (string)$condition, $result ? 'true' : 'false'));

            if ($result == true) {
                return true;
            }
        }

        return false;
    }

    public function supports($entities)
    {
        if (!is_array($entities)) {
            $entities = [$entities];
        }

        foreach ($this->conditions as $condition) {
            if (!array_diff($entities, (array)$condition->requires())) {
                return true;
            }
        }

        return false;
    }
} 