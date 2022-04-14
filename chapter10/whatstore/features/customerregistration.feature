Feature: Customer Registration
  In order to manage customers
  As a customer
  I need to be able to create, recover, update and delete my data from the customer registration
  
  Scenario: Inserting a customer in the registration
    Given a customer called "Jack Sparrow" with IDN 1313 and with e-mail "jacksparrow@pirates.com"
    When I add this customer 
    Then I have a customer called "Jack Sparrow" in the table customers