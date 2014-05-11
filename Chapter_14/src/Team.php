<?php

class Team
{
    private $scoredGoals = 0;
    private $receivedPoints = 0;

    public function scoreGoal()
    {
        return $this->scoredGoals += 1;
    }

    public function getScoredGoals()
    {
        return $this->scoredGoals;
    }

    public function setReceivedPoints($points)
    {
        $this->receivedPoints = $points;
    }

    public function getReceivedPoints()
    {
        return $this->receivedPoints;
    }
}
