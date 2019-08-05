<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    /**
     * @Route("/api", name="api")
     */
class ApiController extends AbstractController
{
   
     /**
     * @Route("/Depot", name="add_depot", methods={"POST"})
     */
    public function depot(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $depot = $serializer->deserialize($request->getContent(), Depot::class, 'json');
        $entityManager->persist($depot);
        $entityManager->flush();
        $data = [
            'statut' => 201,
            'messager' => 'Le Depot a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }

     /**
     * @Route("/Compte", name="add_compte", methods={"POST"})
     */
    public function compte(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $compte = $serializer->deserialize($request->getContent(), Compte::class, 'json');
        //sa me permet de retourner le repository du partenaire
        $repository = $this->getDoctrine()->getRepository(Partenaire::class);
        //$values->Partenaire me permet de recuperer l'id du partenaire
        //$repository ->find permet de retourner l'objet de type partenaire && $partenaire est le type partenaire
        $partenaire=$repository->find($values->Partenaire);

        $entityManager->persist($compte);
        $entityManager->flush();
        $data = [
            'vue' => 201,
            'renvoie' => 'Le compte a bien été rempli'
        ];
        return new JsonResponse($data, 201);
    }
   

     /**
     * @Route("/partenaires", name="add_partenaire", methods={"POST"})
     
     */
    public function ajoutpartenaire(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $partenaire = $serializer->deserialize($request->getContent(), Partenaire::class, 'json');
        $errors = $validator->validate($partenaire);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->persist($partenaire);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'Le partenaire a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }


         /**
        * @Route("/partenaires/{id}", name="update_partenaire", methods={"PUT"})
        */
    public function modifierpartenaire(Request $request, SerializerInterface $serializer, partenaire $partenaire, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $partenaireUpdate = $entityManager->getRepository(Partenaire::class)->find($partenaire->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $partenaireUpdate->$setter($value);
            }
        }
        $errors = $validator->validate($partenaireUpdate);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => 'Le partenaire bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

}

