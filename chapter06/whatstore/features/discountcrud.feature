Feature: Discount CRUD
  In order to manage discounts
  As a employee
  I need to be able to create, recover, update and delete discounts from the discount registration
  
  Rules:
  - Operator is a arithmetic operator, like "-" or "/" 
  - Factor is the second operand (product price is the first) 

  Scenario: Updating a discount in the registration
    Given there is a discount called "50%" with operator "/" and factor "2"
    When I change the name of discount to "10 off" and the operator to "-" and the factor to 10
    Then I have a discount with the operator equals to "-"
    And I have a discount with the factor equal to 10