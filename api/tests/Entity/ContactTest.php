<?php
namespace App\Tests\Entity;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    /**
     * Test that we have at least a plain class of the correct name 
     * and the correct get set methods
     */
    public function testExists()
    {
        $TEST_EMAIL = "test@testdomain.test";
        $TEST_SHORT_MESSAGE = "This is a short message";

        $contact = new Contact();

        $this->assertClassHasAttribute("id", Contact::class);
        $this->assertClassHasAttribute("email", Contact::class);
        $this->assertClassHasAttribute("message", Contact::class);

        $contact->setEmail($TEST_EMAIL);
        $contact->setMessage($TEST_SHORT_MESSAGE);

        $this->assertEquals($contact->getId(),"");
        $this->assertEquals($contact->getMessage(), $TEST_SHORT_MESSAGE);
        $this->assertEquals($contact->getMessage(), $TEST_SHORT_MESSAGE);
    }
}