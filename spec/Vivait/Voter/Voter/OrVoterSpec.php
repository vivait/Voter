<?php

namespace spec\Vivait\Voter\Voter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vivait\Voter\Model\ActionInterface;
use Vivait\Voter\Voter\OrVoter;
use Vivait\Voter\Model\ConditionInterface;
use Vivait\Voter\Model\VoterInterface;

/**
 * @mixin OrVoter
 */
class OrVoterSpec extends ObjectBehavior
{
    public function it_will_return_true_if_any_conditions_are_true(
      ConditionInterface $condition1,
      \Vivait\Voter\Model\ConditionInterface $condition2,
      \Vivait\Voter\Model\ConditionInterface $condition3
    ) {
        $entity = new \stdClass();

        $condition1->requires()->willReturn('stdClass');
        $condition2->requires()->willReturn('stdClass');
        $condition3->requires()->willReturn('stdClass');

        $condition1->result($entity)->willReturn(true)->shouldBeCalled();
        $condition2->result($entity)->willReturn(false)->shouldNotBeCalled();
        $condition3->result($entity)->willReturn(false)->shouldNotBeCalled();

        $this->addConditions([$condition1, $condition2, $condition3]);

        $this->result($entity)->shouldBe(true);
    }

    public function it_will_return_false_if_all_conditions_are_false(
      \Vivait\Voter\Model\ConditionInterface $condition1,
      \Vivait\Voter\Model\ConditionInterface $condition2,
      \Vivait\Voter\Model\ConditionInterface $condition3
    ) {
        $entity = new \stdClass();

        $condition1->requires()->willReturn('stdClass');
        $condition2->requires()->willReturn('stdClass');
        $condition3->requires()->willReturn('stdClass');

        $condition1->result($entity)->willReturn(false)->shouldBeCalled();
        $condition2->result($entity)->willReturn(false)->shouldBeCalled();
        $condition3->result($entity)->willReturn(false)->shouldBeCalled();

        $this->addConditions([$condition1, $condition2, $condition3]);

        $this->result($entity)->shouldBe(false);
    }

    public function it_will_intersect_all_requires(
      \Vivait\Voter\Model\ConditionInterface $condition1,
      \Vivait\Voter\Model\ConditionInterface $condition2,
      \Vivait\Voter\Model\ConditionInterface $condition3
    ) {
        $condition1->requires()->willReturn(
          [
            'stdClass',
            'anotherClass',
            'sharedClass'
          ]
        )->shouldBeCalled();

        $condition2->requires()->willReturn(
          [
            'myClass',
            'rareClass',
            'sharedClass'
          ]
        )->shouldBeCalled();

        $condition3->requires()->willReturn([])->shouldBeCalled();

        $this->addConditions([$condition1, $condition2, $condition3]);

        $this->supports(['sharedClass', 'myClass'])->shouldBe(true);
        $this->supports('sharedClass')->shouldBe(true);

        $this->supports(['sharedClass', 'myClass', 'noClass'])->shouldBe(false);
        $this->supports('newClass')->shouldBe(false);
    }

    public function it_will_handle_require_being_a_string(
      \Vivait\Voter\Model\ConditionInterface $condition1,
      \Vivait\Voter\Model\ConditionInterface $condition2
    ) {
        $condition1->requires()->willReturn('stdClass');
        $condition2->requires()->willReturn(['myClass']);

        $this->addConditions([$condition1, $condition2]);

        $this->supports('stdClass')->shouldBe(true);
        $this->supports('myClass')->shouldBe(true);
    }
}
