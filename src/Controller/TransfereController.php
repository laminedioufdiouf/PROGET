<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\User;
use App\Entity\Tarifs;
use App\Form\TransactionType;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
    * @Route("/api")
    */

class TransfereController extends AbstractController
{
    /**
     * @Route("/transfere", name="transfere",methods={"POST"})
     */
    public function transfere(Request $request,EntityManagerInterface $entityManager)
    {
        $user= new Transaction();
        $form=$this->createForm(TransactionType::class,$user);
        
        $debut=1;
        $annee = date('Y');
        $heure = date('H');
        $seconde=date('s');
        $cni=$debut.$annee.$heure.$seconde;
        $form->handleRequest($request);
        $data=$request->request->all();
        $form->submit($data);
        while(true)
        {
            if(time()%1==00)
            {
                $colle=rand(100,10000000);
                break;
            }
            else
            {
                slep(1);
            }
        }
        //  $connecte=$this->getUser();
        //  $user=$this->getDoctrine()->getRepository(User::class)->find($connecte);
         $user->setCodeenvoie($colle);
         $face=$this->getUser();
         $user->setUser($face);
         $user->setCni($cni);
         $user->setDate(new \DateTime());
         //$user->setMontantenvoye;
        
       $diouf=$form->get('montantenvoie')->getData();
        
        
        $compte=$this->getDoctrine()->getRepository(Tarifs::class)->findAll();
        
        foreach ($compte as $values) {
         $values->getBorneinferieur();
          $values->getBornesuperieur();
          $values->getValeurs();
          if($diouf>=$values->getBorneinferieur() && $diouf<=$values->getBornesuperieur())
          {
              $diouf=$values->getValeurs();
              $user->setEnvoietarifs($diouf);
              $user->setRetraittarifs($diouf*2);
              $user->setEtattarifs($diouf*3);
              $user->setWaritarifs($diouf*4);
             
             
            //   var_dump($user);
            //   die();
       
              
          }

          
        }
     //   $values->montanttotal=$user->setEnvoiTarif($laye*2)+$lay->get('mtntenvoi');
        $user->setMontanttotal($user->getEnvoieTarifs()+$user->getMontantenvoie());
        $entityManager->persist($user);
        $entityManager->flush();
       return new Response('transfert reussi voici le reçu d\'envoi:'."<br>"
       .$user->getNomexp()."<br>"
       .$user->getPrenomexp()."<br>"
       .$user->getTelephoneexp()."<br>"
       .$user->getNomrecep()."<br>"
       .$user->getPrenomrecep()."<br>"
       .$user->getTelephonerecep()."<br>"
       .$user->getCodeenvoie()."<br>"
       .$user->getMontanttotal()."<br>"
    );
    //    $compt=$this->getUser();
    //   $compt=$this->getDoctrine()->getRepository(Compte::class)
    //      ->find($compt);
       

    //      if($compt->getMontant()>$user->getMontantenvoie())
    //      {
    //          $money=$compt->getMontant()-$user->getMontantenvoi()+$user->getEnvoiTarif();
    //          $compt->setMontant($money);
    //          $entityManager->persist($compt);
    //          $entityManager->flush();
    //          return new Response('transfert reussi voici le code:'.$user->getCodenvoi());
    //      }
    //      else
    //      {
    //          return new Response('solde insuffisant');
    //      }
    }
}
