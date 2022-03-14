Feature: Product inserting
  In order to have products in the stock
  As a employee
  I need to be able to add a product to the product registration

  Rules:
  - The code of product is generated automatically
  - Product name has a maximum of 80 characters 
  - A product must have a discount, and the default discount is the null discount 

  Scenario: Inserting a product in the registration
    Given there is a product called "Troop Power Battery", which costs $2814
    When I add this product to the registration
    Then I should have a product called "Troop Power Battery" in the table products
    And the overall product price should be $2814