<?php

use Behat\Behat\Context\BehatContext,
    Behat\Gherkin\Node\PyStringNode;

//
// Require 3rd-party libraries here:

// for PHPUnit 3.7
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

// for PHPUnit 4.x
//include 'phar://phpunit.phar/phpunit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
   /**
     * @var \Match
     */
    private $match;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters) {}

    /**
     * @Given /^New Match$/
     */
    public function newMatch()
    {
        $this->match = new \Match(new \Team, new \Team);
    }

    /**
     * @Then /^Score should be$/
     */
    public function scoreShouldBe(PyStringNode $string)
    {
        assertEquals('0 : 0', $this->match->getScore());
    }

    /**
     * @Then /^Home team scores goal$/
     */
    public function homeTeamScoresGoal()
    {
        $this->match->homeTeam->scoreGoal();
    }

    /**
     * @Given /^Visitors team scores goal$/
     */
    public function visitorsTeamScoresGoal()
    {
        $this->match->visitorsTeam->scoreGoal();
    }

    /**
     * @Given /^Match ends$/
     */
    public function matchEnds()
    {
        $this->match->gameOver();
    }

    /**
     * @Then /^The Match ends with score$/
     */
    public function theMatchEndsWithScore(PyStringNode $string)
    {
        assertEquals($string->getRaw(), $this->match->getScore());
    }

    /**
     * @Given /^Home team gets points$/
     */
    public function homeTeamGetsPoints(PyStringNode $string)
    {
        assertEquals($string->getRaw(), $this->match->homeTeam->getReceivedPoints());
    }
}
