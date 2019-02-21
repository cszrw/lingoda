<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $apiContext;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $this->apiContext = $scope->getEnvironment()->getContext(
            \Imbo\BehatApiExtension\Context\ApiContext::class    
        );
    }

    /**
     * @BeforeSCenario
     */
    public function cleanUpDatabase(){
        $host = '127.0.0.1';
        $db = 'lingoda_contact_test';
        $port = '3336';
        $user = "lingoda";
        $pass = 'lingoda';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES      => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $pdo->query('TRUNCATE contact');

    }


      /**
     * @Given there are Contacts with the following details:
     */
    public function thereAreContactsWithTheFollowingDetails(TableNode $contacts)
    {
        foreach($contacts->getColumnsHash() as $contact){
            $this->apiContext->setRequestBody(
                json_encode($contact)
            );
            $this->apiContext->requestPath(
                "/contact",
                "POST");
        }
    }

}
