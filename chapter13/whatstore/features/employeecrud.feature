Feature: Employee CRUD
  In order to manage employees
  As a employee
  I need to be able to create, recover, update and delete employees
  
  Scenario: Inserting a employee in the registration
    Given an employee called "Solomon" with ID 3141 and with nickname "Grundy"
    When I add this employee
    Then I have an employee called "Solomon" in the table employees