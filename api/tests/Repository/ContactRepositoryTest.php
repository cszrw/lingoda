<?php

namespace App\Tests\Repository;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactRepositoryTest extends KernelTestCase
{
    private $TEST_EMAIL = "test@testdomain.test";
    private $TEST_MESSAGE_SHORT = "This is a short test message.";
    private $TEST_MESSAGE_TOO_LONG = "";
    private $TEST_MESSAGE_MAX = "";

    public $testContact;
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->connection = $kernel->getContainer()->get('doctrine.dbal.default_connection');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        for ($i = 0; $i < 1000;  $i++){
            $this->TEST_MESSAGE_MAX .= "a";
        }
        $this->TEST_MESSAGE_TOO_LONG = $this->TEST_MESSAGE_MAX . "a";
        $this->beforeEach();
    }

    protected function beforeEach(){
        $this->deleteAllContacts();

        $this->testContact = new Contact();
        $this->testContact->setEmail($this->TEST_EMAIL);
        $this->testContact->setMessage($this->TEST_MESSAGE_SHORT);
        
        $this->entityManager->persist($this->testContact);
        $this->entityManager->flush();
    }

    public function testFindByEmail()
    {
        $contacts = $this->entityManager
            ->getRepository(Contact::class)
            ->findByEmail($this->TEST_EMAIL)
        ;

        $this->assertCount(1, $contacts);
    }

    public function testPersitsCorrectMessage()
    {
        $contacts = $this->entityManager
            ->getRepository(Contact::class)
            ->findByEmail($this->TEST_EMAIL);

        $contact = $contacts[0];
        $this->assertEquals($contact->getMessage(),$this->TEST_MESSAGE_SHORT );
    }

    public function testRejectsLongMessage()
    {
        $this->assertEquals( 1000, strlen($this->TEST_MESSAGE_MAX));
        $this->assertEquals( 1001, strlen($this->TEST_MESSAGE_TOO_LONG));
       
        // Empty the table
        $this->deleteAllContacts();

        $contact = new Contact();
        $contact->setEmail($this->TEST_EMAIL);
        $contact->setMessage($this->TEST_MESSAGE_TOO_LONG);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        $contacts = $this->getContactsByEmail();
        $this->assertCount(0, $contacts);
    }

    public function testRejectsEmptyEmail()
    {
        // Empty the table
        $this->deleteAllContacts();

        $contact = new Contact();
        $contact->setEmail($this->TEST_EMAIL);
        $contact->setMessage($this->TEST_MESSAGE_TOO_LONG);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        $contacts = $this->getAllContacts();
        $this->assertCount(0, $contacts);
    }

    public function testRejectsEmptyMessage()
    {
        // Empty the table
        $this->deleteAllContacts();

        $contact = new Contact();
        $contact->setEmail($this->TEST_EMAIL);
        $contact->setMessage("");

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        $contacts = $this->getContactsByEmail();
        $this->assertCount(0, $contacts);
    }

    public function testacceptsMaxMessage()
    {
        $this->assertEquals( 1000, strlen($this->TEST_MESSAGE_MAX));
       
        $contact = new Contact();
        $contact->setEmail($this->TEST_EMAIL);
        $contact->setMessage($this->TEST_MESSAGE_MAX);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        $contacts = $this->getContactsByEmail();
        $this->assertCount(2, $contacts);
    }

    private function getContactsByEmail(){
        return $this->entityManager
        ->getRepository(Contact::class)
        ->findByEmail($this->TEST_EMAIL);
    }

    private function getAllContacts(){
        $sql = 'SELECT * FROM Contact';
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $contacts = $stmt->fetchAll();
        $stmt->closeCursor();
        return $contacts;
    }

    protected function afterEach(){
        $this->entityManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(){
        $this->afterEach();
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    private function deleteAllContacts(){
        $sql = 'DELETE FROM Contact';
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $stmt->closeCursor();
    }
}