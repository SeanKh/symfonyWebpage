<?php
    namespace App\Controller;

    use App\Entity\User;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\HiddenType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
    
    

    class UserController extends AbstractController{
        /**
         * @Route("/", name="user-list")
         * @Method({"GET"})
         */
        public function index(){
            
            $users= $this->getDoctrine()->getRepository(User::class)->findAll();
            //return new Response('<html><body>Hello</body></html>');
            
            return $this->render('users/index.html.twig', array
            ('users' => $users));
        }

        function createUserForm($method, $user) {

            $buttonTitle = $method == 'PUT' ? 'Create': 'Update';

            $form=$this->createFormBuilder($user)
                ->setMethod($method)
                ->add('id',HiddenType::class,array('attr'=>array('class'=>'form-control')))
                ->add('firstName',TextType::class,array('attr'=>array('class'=>'form-control')))
                ->add('lastName',TextType::class, array(
                    'required' => false,
                    'attr'=>array('class'=>'form-control')
                ))
                ->add('dateOfBirth',DateType::class, array(
                    'required' => false,
                    'years' => range(date('Y')-10, date('Y')-100),
                    'attr'=>array('class'=>'form-control')
                ))
                ->add('email',TextType::class, array(
                    'required' => false,
                    'attr'=>array('class'=>'form-control')
                ))
                ->add('save',SubmitType::class,array(
                    'label' => $buttonTitle,
                    'attr' => array('class'=> 'btn btn-primary mt-3')
                ))
                ->getForm();

            return $form;
        }

        /**
         * @Route("/user/new", name="new_user")
         * Method({"GET", "PUT"})
         */
        public function createUser(Request $request){
            $user=new User();
            $form = $this->createUserForm('PUT',$user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $user=$form->getData();
                $user->setDateCreated(new \DateTime());
                $user->setDateUpdated(new \DateTime());
                
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('user-list');
            }

            return $this->render('users/new.html.twig', array(
                'form' => $form->createView()
            ));

        }

        /**
         * @Route("/user/edit/{id}", name="edit_user")
         * Method({"GET", "POST"})
         */
        public function editUser(Request $request, $id){
            $dbUser = $this->getDoctrine()->getRepository(User::class)->find($id);
            if(is_null($dbUser)) {
                return $this->redirectToRoute('not-found');
            }
            $form = $this->createUserForm('POST', $dbUser);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $user=$form->getData();

                $dbUser->setDateUpdated(new \DateTime());
                $dbUser->setLastName($user->getLastName()); 
                $dbUser->setFirstName($user->getFirstName()); 
                $dbUser->setDateOfBirth($user->getDateOfBirth());  
                $dbUser->setEmail($user->getEmail()); 

                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('user-list');
            }

            return $this->render('users/new.html.twig', array(
                'form' => $form->createView()
            ));

        }

        /**
         * @Route("/user/{id}", name="user-show")
         */
        public function show($id){
            $user=$this->getDoctrine()->getRepository(User::class)->find($id);
            if(is_null($user)) {
                return $this->redirectToRoute('not-found');
            }
            
            return $this->render('users/show.html.twig',array('user'=>$user));
        }

        /**
         * @Route("/user/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id) {
            
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
    
            $response = new Response();
            $response->send();
        }

        /**
         * @Route("/404", name="not-found")
         */
        public function notFound(){
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            return $this->render('inc/404.html.twig',array(), $response);
        }

        // /**
        //  * @Route("/user/save")
        //  */
        // public function save(){
        //     $entityManager=$this ->getDoctrine()->getManager();

        //     $user=new User();

        //     $user->setFirstName("Shon2");
        //     $user->setLastName("Khaydarov");
        //     $user->setDateOfBirth(new \DateTime("11-11-2010"));
        //     $user->setEmail("sh.khaydarovsh@gmail.com");
        //     $user->setDateCreated(new \DateTime("11-10-2015"));
        //     $user->setDateUpdated(new \DateTime("11-10-2020"));

        //     $entityManager->persist($user);

        //     $entityManager->flush();

        //     return new Response('Saved user with id '.$user->getId());
        // }


    }