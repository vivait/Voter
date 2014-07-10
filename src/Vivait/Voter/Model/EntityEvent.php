<?php

namespace Vivait\Voter\Model;

interface EntityEvent {
    public function provides();
    public function getEvents();
} 