<?php

namespace Vivait\Voter\Model;

interface ActionInterface {
    public function requires();
    public function perform($entities);
}
