<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
/** 
 * @Route("/api")
 */
class PartenaireController extends AbstractController
{
   


    /** 
     * @Route("/Partenaire", name="partenaire",  methods={"POST"})
     */
    public function CreerPartenaire(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, SerializerInterface $serializer,ValidatorInterface $validator)
    {
        $values = json_decode($request->getContent());
        if (isset($values->username, $values->password)){
            $partenaire = new Partenaire();
            $partenaire->setNinea($values->ninea);
            $partenaire->setRaisonsociale($values->raisonsociale);
            $partenaire->setAdress($values->adress);
            $partenaire->setStatut($values->statut);
            //creer un compte
            $compte = new Compte();
            $random= random_int(300000, 600000);
            $compte->setNumerocompte("$random");
            $compte->setMontant($values->montant);
             // relates this product to the category
             $compte->setPartenaire($partenaire);
             //faire un depot
             $depot = new Depot();
             $depot->setDatedepot(new \DateTime);
            $depot->setSolde($values->solde);
            $depot->setCompte($compte);

             $errors = $validator->validate($compte);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, ['Conten-Type' => 'Application/json']);
        }
             // admini$compte->setPartenaire($partenaire);strateur du partenaire
            $user = new User();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
           
            $user->setProfil($values->profil);
            $profil=$user->getProfil();
           
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
            $user->setRoles([$roles]);
            $user->setNom($values->nom);
            $user->setAdresse($values->adresse);
            $user->setEmail($values->email);
            $user->setTelephone($values->telephone);
            

            $user->setPartenaire($partenaire);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->persist($compte);
            $entityManager->persist($depot);
            $entityManager->persist($user);
            

            $entityManager->flush();

             $data = [
                'Le partenaire: '.$partenaire->getNinea().' a été bien créer'
                .' avec un muméro de compte : '.$compte->getNumerocompte().' et comme administrateur principal '.$user->getNom()
             ];
             return new JsonResponse($data);
        }
        
    }
}
