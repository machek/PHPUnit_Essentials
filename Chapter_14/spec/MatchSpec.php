<?php
namespace spec;

use PhpSpec\ObjectBehavior;

class MatchSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith(new \Team, new \Team);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Match');
    }

    public function it_has_initial_score()
    {
        $this->getScore()->shouldBe('0 : 0');
    }

    public function it_has_score_two_one()
    {
        $this->homeTeam->scoreGoal()->shouldReturn(1);
        $this->homeTeam->scoreGoal()->shouldReturn(2);
        $this->visitorsTeam->scoreGoal()->shouldReturn(1);
        $this->getScore()->shouldBe('2 : 1');
    }

    public function it_gives_home_team_three_points()
    {
        $this->homeTeam->scoreGoal()->shouldReturn(1);
        $this->gameover();
        $this->homeTeam->getReceivedPoints()->shouldReturn(3);
        $this->visitorsTeam->getReceivedPoints()->shouldReturn(0);
    }
}
