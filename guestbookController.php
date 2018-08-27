<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\guestbook;

class guestbookController extends Controller
{
    /**
     * @Route("/index", name="guestbook_list")
     *
     */
    public function indexAction(Request $request)
    {
        $guestbook = $this->getDoctrine()
            ->getRepository('AppBundle:guestbook')
            ->findAll();
        return $this->render('/guestbook/index.html.twig',array('guestbook'=>$guestbook));
    }
    /**
     * @Route("/create", name="/guestbook_create")
     *
     */
    public function createAction(Request $request)
    {
        $guestbook = new guestbook;
        $form = $this->createFormBuilder($guestbook)
            ->add('name',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
            ->add('address',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
            ->add('email',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
            ->add('message',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
            ->add('save',SubmitType::class,array('label'=>'Create Guestbook','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $name=$form['name'];
            $address=$form['address'];
            $email=$form['email'];
            $message=$form['message'];

            $guestbook->setName($name);
            $guestbook->setAddress($address);
            $guestbook->setEmail($email);
            $guestbook->setMessage($message);

            $em=$this->getDoctrine()->getManager();
            $em->persist($guestbook);
            $em->flush();
            $this->addFlash('notice','Guestbook added');
            return $this->redirectToRoute('guestbook');
        }


    //return($arr);
return new JsonResponse($arr);
     //return(json_encode(arr));*/
        return $this->render('/guestbook/create.html.twig',array('form'=>$form.createView()));
    }

    public function guestStore(Request $request)
    {
        echo "Guests added successfully";
        //die('GUESTBOOK');
        // replace this example code with whatever you need
        return $this->render('/guestbook/index.html.twig');
    }
}
