<?php

class Match
{
    /**
     * @var Team
     */
    public $homeTeam;

    /**
     * @var Team
     */
    public $visitorsTeam;

    public function __construct(Team $homeTeam, Team $visitorsTeam)
    {
        $this->homeTeam = $homeTeam;
        $this->visitorsTeam = $visitorsTeam;
    }

    public function getScore()
    {
        return $this->homeTeam->getScoredGoals() . ' : ' .$this->visitorsTeam->getScoredGoals();
    }

    public function gameOver()
    {
        $this->homeTeam->setReceivedPoints($this->getReceivedPointsHome());
        $this->visitorsTeam->setReceivedPoints($this->getReceivedPointsVisitors());
    }

    private function getReceivedPointsHome()
    {
        if($this->homeTeam->getScoredGoals() > $this->visitorsTeam->getScoredGoals())
        {
            return 3;
        }
        else if($this->homeTeam->getScoredGoals() < $this->visitorsTeam->getScoredGoals())
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    private function getReceivedPointsVisitors()
    {
        if($this->homeTeam->getScoredGoals() < $this->visitorsTeam->getScoredGoals())
        {
            return 3;
        }
        if($this->homeTeam->getScoredGoals() > $this->visitorsTeam->getScoredGoals())
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
}
