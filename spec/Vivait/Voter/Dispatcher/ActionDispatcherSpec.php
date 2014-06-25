<?php

namespace spec\Vivait\Voter\Dispatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vivait\Voter\Model\ActionInterface;
use Vivait\Voter\Dispatcher\ActionDispatcher;
use Vivait\Voter\Model\VoterInterface;

/**
 * @mixin ActionDispatcher
 */
class ActionDispatcherSpec extends ObjectBehavior
{
    function let(\Vivait\Voter\Model\VoterInterface $voter)
    {
        $this->beConstructedWith($voter);
    }

    function it_can_store_multiple_actions(
      \Vivait\Voter\Model\ActionInterface $action1, \Vivait\Voter\Model\ActionInterface $action2)
    {
        $this->addAction($action1);
        $this->addAction($action2);

        $this->getActions()->shouldHaveCount(20);

        $this->removeAction($action1);
        $this->getActions()->shouldHaveCount(1);
    }

    function it_can_add_actions_from_an_array(
      \Vivait\Voter\Model\ActionInterface $action1,
      \Vivait\Voter\Model\ActionInterface $action2,
      \Vivait\Voter\Model\ActionInterface $action3
    ) {
        $this->addActions([$action1, $action2, $action3]);

        $this->getActions()->shouldHaveCount(3);
    }

    function it_can_accept_actions_in_the_construct(
      \Vivait\Voter\Model\VoterInterface $voter,
      \Vivait\Voter\Model\ActionInterface $action1,
      \Vivait\Voter\Model\ActionInterface $action2,
      \Vivait\Voter\Model\ActionInterface $action3
    ) {
        $this->beConstructedWith($voter, [$action1, $action2]);
        $this->addAction($action3);

        $this->getActions()->shouldHaveCount(3);
    }

    public function it_can_perform_actions(\Vivait\Voter\Model\VoterInterface $voter, \Vivait\Voter\Model\ActionInterface $action1)
    {
        $entity = new \stdClass();

        $action1->requires()->willReturn('stdClass')->shouldBeCalled();

        $action1->perform($entity)->willReturn(true)->shouldBeCalled();

        $this->addAction($action1);

        $voter->result($entity)->willReturn(true)->shouldBeCalled();

        $this->perform($entity);
    }

    public function it_can_halt_future_actions_if_one_returns_false(
      \Vivait\Voter\Model\VoterInterface $voter,
      \Vivait\Voter\Model\ActionInterface $action1,
      \Vivait\Voter\Model\ActionInterface $action2
    ) {
        $entity = new \stdClass();

        $action1->requires()->willReturn('stdClass')->shouldBeCalled();
        $action2->requires()->willReturn('stdClass')->shouldBeCalled();

        $action1->perform($entity)->willReturn(false)->shouldBeCalled();
        $action2->perform($entity)->shouldNotBeCalled();

        $this->addActions([$action1, $action2]);

        $voter->result($entity)->willReturn(true)->shouldBeCalled();

        $this->perform($entity);
    }
}
