<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Contact;
use App\Form\ContactType;

/**
 * Contact controller.
 * @Route("/api", name="api_")
 */
class ContactController extends FOSRestController
{

  /**
   * Lists all Contacts.
   * @Rest\Get("/contacts")
   *
   * @return Response
   */
  public function getContactAction()
  {
    $repository = $this->getDoctrine()->getRepository(Contact::class);
    $contacts = $repository->findall();
    return $this->handleView($this->view($contacts));
  }

  /**
   * Create Contact.
   * @Rest\Post("/contact")
   *
   * @return Response
   */
  public function postContactAction(Request $request)
  {
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);
    $data = json_decode($request->getContent(), true);
    $form->submit($data);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($contact);
      $em->flush();
      return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    return $this->handleView($this->view($form->getErrors()));
  }
}

// namespace App\Controller;

// use FOS\RestBundle\Controller\FOSRestController;
// use App\Entity\ValidationException as VE;

// class ContactController extends FOSRestController
// {
//      /**
//      * Create Contact.
//      * @FOSRest\Post("/contact")
//      *
//      * @return array
//      */
//     public function postContactsAction(Request $request)
//     {
//         $contact = new Contact();
//         $contact->setEmail($request->get('email'));
//         $contact->setMessage($request->get('message'));
//         // Run through the validator service

//         // Return bad request response if request is invalid

//         $em = $this->getDoctrine()->getManager();
//         try{
//             $em->persist($contact);
//             $em->flush();
//             return View::create($contact, Response::HTTP_CREATED , []);
//         }catch(VE $ve){
//             // Do something if domain constraints fail
//             // Return error response if request invalid
//             // or maybe as this should never happen if 
//             // request validation is correct rethrow the 
//             // Exception
//         }
//     }

//     /**
//      * Lists all Contacts.
//      * @FOSRest\Get("/contact")
//      * @return array
//      */
//     public function getContactAction()
//     {
//         $repository = $this->getDoctrine()->getRepository(Contact::class);
        
//         $contacts = $repository->findall();
        
//         return View::create($contacts, Response::HTTP_OK , []);
//     }
// }
   