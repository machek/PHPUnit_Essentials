<?php

namespace spec;

use PhpSpec\ObjectBehavior;

class TeamSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Team');
    }

    public function it_scores_goal()
    {
        $this->scoreGoal()->shouldReturn(1);
    }
}
