<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\UserType;
use App\Form\DepotType;
use App\Form\CompteType;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Repository\PartenaireRepository;
use App\Repository\UserRepository;
use App\Repository\DepotRepository;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
    /**
    * @Route("/api")
    */

class SecurityController extends FOSRestController
{
               //==========lister_partenaire============//
    /**
     * @Rest\Get("/partenaire", name="find_partenaire")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Partenaire::class);
        $partenaire = $repo->findAll();

        return $this->handleView($this->view($partenaire));
    }
            //==========lister_user============//
    /**
     * @Rest\Get("/user", name="find_user")
     */
    public function indexee()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();

        return $this->handleView($this->view($user));
    }

            //==========lister_depot============//
    /**
     * @Rest\Get("/depot", name="find_depot")
     */
    public function indexe()
    {
        $repo = $this->getDoctrine()->getRepository(Depot::class);
        $depot = $repo->findAll();

        return $this->handleView($this->view($depot));
    }
            //==========lister_compte============//
    /**
     * @Rest\Get("/compte", name="find_compte")
     */
    public function listCompte()
    {
        $repo = $this->getDoctrine()->getRepository(Compte::class);
        $compte = $repo->findAll();

        return $this->handleView($this->view($compte));
    }


     /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));


            $user->setProfil($values->profil);
            $profil=$user->getProfil();
            $roles=[];
            if($profil =="admin"){
                $roles=["ROLE_ADMIN"];
            }
            elseif($profil == "superadmin"){
                $roles=["ROLE_SUPER_ADMIN"];
            }
            elseif($profil == "user"){
                $roles=["ROLE_USER"];
            }
            elseif($profil == "caissier"){
                $roles=["ROLE_CAISSIER"];
            } 
            
            $user->setRoles(['']);
            $user->setNom($values->nom);
            $user->setAdresse($values->adresse);
            $user->setEmail($values->email);
            $user->setTelephone($values->telephone);
            

            $errors = $validator->validate($user);
            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }

            $entityManager->persist($user);  
            $entityManager->flush();

            $data = [
                'statut' => 201,
                'messag' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'statut' => 500,
            'messag' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
        }

        /**
        * @Route("/login_check", name="login", methods={"POST"})
        */
        public function login(Request $request)
        {
            $user = $this->getUser();
            return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
            ]);
        }
    /**   
     * @Route("/Entreprise", name="app_entreprise", methods={"POST"})
     */
    public function addadmin(Request $request, UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
          
        $random= random_int(300000, 600000);
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        $data = $request->request->all();
        //$data=json_decode($request->getContent(),true);
        $form->submit($data);
        $partenaire->setStatut('Debloquer');

        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);
        $data = $request->request->all();
        $form->submit($data);
        $compte->setNumerocompte($random);

        // relates this product to the category
        $compte->setPartenaire($partenaire);
        $errors = $validator->validate($compte);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, ['Conten-Type' => 'Application/json']);
        }
          
        $depot = new Depot();
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);
        $data = $request->request->all();
        $form->submit($data);
        $depot->setDatedepot(new \DateTime);
        // relates this product to the category
        $depot->setCompte($compte);

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data = $request->request->all();
        $form->submit($data);
        // encode the plain password
        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));


        $user->setProfil($data['profil']);
            $profil=$user->getProfil();
            $roles=[];
            if($profil =="admine"){
                $roles=["ROLE_ADMIN"];
            }
            elseif($profil == "superadmin"){
                $roles=["ROLE_SUPER_ADMIN"];
            }
            elseif($profil == "user"){
                $roles=["ROLE_USER"];
            }
            elseif($profil == "caissier"){
                $roles=["ROLE_CAISSIER"];
            } 
 
        $user->setRoles($roles);
        
       
        $user->setPartenaire($partenaire);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->persist($compte);
            $entityManager->persist($depot);
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'Le partenaire a bien été ajouté'
            ];
            return new JsonResponse($data, 201);
        }

        $data = [
            'status' => 500,
            'message' => 'Le partenaire n\'a pas entré'
        ];
        return new JsonResponse($data, 201);
    }
}
