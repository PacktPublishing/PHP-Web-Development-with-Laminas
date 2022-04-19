Feature: Product updating
  In order to keep products up-to-date in the stock
  As an employee
  I need to be able to change data of a product from the product registration

  Scenario: Updating a product in the registration
    Given I have a product called "Troop Power Battery", which costs $2814
    When I change the name of product to "Enchanted Hammer"
    Then there is a product in the table products called "Enchanted Hammer"
