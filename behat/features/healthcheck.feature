Feature: Ensure ping response from api

    Make sure the api is up

    Scenario: Ping Healthcheck
        Given I request '/ping' using HTTP GET
        Then the response code is 200
        And The response body is:
        """
        "pong"
        """ 