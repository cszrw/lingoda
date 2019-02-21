Feature: Provide an api for persiting contact reqauests
    Background:
        Given there are Contacts with the following details:
            | email             | message                       |
            | test@test.test    | This is a short test message  |
            | test@testy.test   | This is a shortish test message  |

    Scenario: Can get a list of contacts
        Given I request "api/contact" using HTTP GET
        Then The response code is 200
        And the response body contains JSON:
        """
        {
            "id":1,
            "email":"test@test.test",
            "message":"This is a short test message"
        }
        """

    Scenario: Can get a single contact
        Given I request "api/contact/1" using HTTP GET
        Then The response code is 200
        And the response body contains JSON:
        """
        {
            "id":1,
            "email":"test@test.test",
            "message":"This is a short test message"
        }
        """

    Scenario: Can add a new contact
        Given the request body is:
            """
            {
            "email":"test@test.test",
            "message":"This is a short test message"
            }
            """
        When I request "api/contact" using HTTP POST
        Then The response code is 201

    Scenario: Can reject a bad email contact
        Given the request body is:
            """
            {
            "email":"",
            "message":"This is a short test message"
            }
            """
        When I request "api/contact" using HTTP POST
        Then The response code is 500

    Scenario: Can reject a bad message contact
        Given the request body is:
            """
            {
            "email":"test@test.test",
            "message":""
            }
            """
        When I request "api/contact" using HTTP POST
        Then The response code is 500