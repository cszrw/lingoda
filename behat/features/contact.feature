Feature: Provide an api for persiting contact reqauests
    Background:
        Given there are Contacts with the following details:
            | email             | message                       |
            | test@test.test    | This is a short test message  |

    Scenario: Can get a single contact
        Given I request "contacts/1" using HTTP GET
        Then The response code is 200
        And the response body contains JSON:
        """
        {
            "id":1
            "email":"test@test.test"
            "message":"This is a short test message"
        }
        """

    Scenario: Can add a new contact
        Given the request body is:
            """
            {
            "email":"test@test.test"
            "message":"This is a short test message"
            }
            """
        When I request "/contacts" using HTTP POST
        Then the response code is 201