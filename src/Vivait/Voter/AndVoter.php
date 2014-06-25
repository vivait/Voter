<?php

namespace Vivait\Voter;

use Vivait\Voter\VoterAbstract;

class AndVoter extends VoterAbstract
{
    public function result($entity)
    {
        foreach ($this->conditions as $condition) {
            if ($condition->result($entity) === false) {
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