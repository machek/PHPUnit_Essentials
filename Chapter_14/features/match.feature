Feature: Football match

  Scenario: Match starts
    Given New Match
    Then Score should be
    """
    0 : 0
    """

  Scenario: Home teams wins 2 : 1
    Given New Match
    Then Home team scores goal
    And  Visitors team scores goal
    And Home team scores goal
    And Match ends
    Then The Match ends with score
    """
    2 : 1
    """
    And Home team gets points
    """
    3
    """