<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Joueur;
use App\Entity\Vote;
use App\Form\VoteType;

class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function index(ManagerRegistry $doctrine,Request $request, EntityManagerInterface $entityManager): Response
    {
        $joueurs = $doctrine->getRepository(Joueur::class)->findJoueurTrieByName();
        //$joueurs = $doctrine->getRepository(Joueur::class)->showJoueurs();
        //codeform mtaa ajouter vote
        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($vote);
            $entityManager->flush();
            return $this->redirectToRoute('app_joueur');
        }
        //fin code form
        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
            'joueurs'=>$joueurs,
            'form' => $form->createView()
        ]);
    }
    
    /* souel el khamess 
    
    1. php bin/console make:entity Joueur 
    2. moyenneVote -> float
    3. php bin/console make:migration
    4. php bin/console doctrine:migrations:migrate
    */


    #[Route('/details/{id}', name: 'details_joueur')]
    public function modif($id,Request $request, EntityManagerInterface $entityManager,ManagerRegistry $doctrine): Response
    {
        $qb = $entityManager->createQueryBuilder();
        $qb->select('v')
            ->from(Vote::class, 'v')
            ->join('v.joueur', 'j')
            ->where('j.vote_id = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        $votes = $query->getResult();
        $joueur = $doctrine->getRepository(Joueur::class)->findBy($id);
        return $this->render('joueur/modifier.html.twig', [
            'controller_name' => 'JoueurController',
            'votes'=>$votes,
            'joueur'=>$joueur
        ]);
    }
}
