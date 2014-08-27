<?php

namespace Vivait\Voter\Voter;

use Vivait\Voter\Model\ConditionInterface;

class AndVoter extends VoterAbstract
{
    public function result($entity)
    {
        foreach ($this->conditions as $condition) {
            $result = $condition->result($entity);
            $this->logger->debug(
              sprintf('Condition "%s" returned result: %s', (string)$condition, $result ? 'true' : 'false')
            );

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

        $requirements = $this->getRequirements();

        // Loop through each requirement
        foreach ($requirements as $requirement) {

            foreach ($entities as $entity) {
                if ($entity instanceOf $requirement) {
                    continue 2;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    private function getRequirements()
    {
        $requirements = [];
        foreach ($this->conditions as $condition) {
            $requirements = array_merge($requirements, $condition->requires());
        }

        return $requirements;
    }
} 