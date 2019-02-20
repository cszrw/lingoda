<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Events;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Your e-mail address must be at least {{ limit }} characters long",
     *      maxMessage = "Your e-mail address cannot be longer than {{ limit }} characters"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank()
     * /**
     * @Assert\Length(
     *      min = 2,
     *      max = 1000,
     *      minMessage = "Your message must be at least {{ limit }} characters long",
     *      maxMessage = "Your message cannot be longer than {{ limit }} characters"
     * )
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @ORM\PrePersist @ORM\PreUpdate
     */
    public function validate(){
        print("Validate called");
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $errors = $validator->validate($this);
    
        if (count($errors) > 0) {
            print("Errors: " . $errors);
            throw new ValidationException($errors);
        }
    }
}
