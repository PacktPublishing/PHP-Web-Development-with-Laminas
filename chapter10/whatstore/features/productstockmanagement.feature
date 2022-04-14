Feature: Product stock management
  In order to manage product amounts in the stock
  As a employee
  I need to be able to change product amounts

  Scenario: Product input in the stock
    Given there is a registered product called "Shrink pill", which costs $1453
    When I add 2500 units in stock
    Then I should have 2500 "Shrink pill" in the table inventory