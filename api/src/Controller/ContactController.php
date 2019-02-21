<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Serializer\FormErrorSerializer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contact controller.
 * @Route("/api", name="api_")
 */
class ContactController extends FOSRestController
{

  /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
    * @var FormErrorSerializer
    */
    private $formErrorSerializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormErrorSerializer $formErrorSerializer

    ) {
        $this->entityManager = $entityManager;
        $this->formErrorSerializer = $formErrorSerializer;
    }

  /**
   * Lists all Contacts.
   * @Rest\Get("/contact")
   *
   * @return Response
   */
  public function getContactAction()
  {
    $repository = $this->getDoctrine()->getRepository(Contact::class);
    $contacts = $repository->findall();
    return new JsonResponse(json_encode($contacts), JsonResponse::HTTP_OK);
  }

  /**
   * Create Contact.
   * @Rest\Post("/contact")
   * @Route("/contact", name="post_contact", methods={"POST"})
   * @return Response
   */
  public function postContactAction(Request $request)
  {

    $data = json_decode($request->getContent(), true);
    $form = $this->createForm(ContactType::class, new Contact());
    $form->submit($data);
    if (false === $form->isValid()) {
      return new JsonResponse(
          [
              'status' => 'error',
              'errors' => $this->formErrorSerializer->convertFormToArray($form),
          ],
         JsonResponse::HTTP_BAD_REQUEST
      );
    }
    $this->entityManager->persist($form->getData());
    $this->entityManager->flush();

    return new JsonResponse(
        [
            'status' => 'ok',
        ],
        JsonResponse::HTTP_CREATED
    );

    // $contact = new Contact();
    // $form = $this->createForm(ContactType::class, $contact);
    // $data = json_decode($request->getContent(), true);
    // $form->submit($data);
    // if ($form->isSubmitted() && $form->isValid()) {
    //   $em = $this->getDoctrine()->getManager();
    //   $em->persist($contact);
    //   $em->flush();
    //   return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    // }
    // return $this->handleView($this->view($form->getErrors()));
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
   