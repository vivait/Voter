<?php

namespace Vivait\Voter;

use Vivait\Voter\VoterAbstract;

class OrVoter extends VoterAbstract {
    public function result($entity) {
        foreach ($this->conditions as $condition) {
            if ($condition->result($entity) === true) {
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