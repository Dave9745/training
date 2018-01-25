<?php

namespace Sparrow\PlatformBundle\Controller;

use Sparrow\PlatformBundle\Entity\Advert;
use Sparrow\PlatformBundle\Entity\Image;
use Sparrow\PlatformBundle\Entity\Application;
use Sparrow\PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdvertController extends Controller
{
    public function indexAction($page)
    {
       
        $listAdverts = array(
             array(
               'title'   => 'Recherche développpeur Symfony',
               'id'      => 1,
               'author'  => 'Alexandre',
               'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
               'date'    => new \Datetime()),
             array(
               'title'   => 'Mission de webmaster',
               'id'      => 2,
               'author'  => 'Hugo',
               'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
               'date'    => new \Datetime()),
             array(
               'title'   => 'Offre de stage webdesigner',
               'id'      => 3,
               'author'  => 'Mathieu',
               'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
               'date'    => new \Datetime())
        );

        return $this->render('SparrowPlatformBundle:Advert:index.html.twig', array(
          'listAdverts' => $listAdverts
        ));
    }
    
    public function viewAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $advert = $em->getRepository('SparrowPlatformBundle:Advert')->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        
         // On récupère la liste des candidatures de cette annonce
        $listApplications = $em
          ->getRepository('SparrowPlatformBundle:Application')
          ->findBy(array('advert' => $advert))
        ;
        
        //var_dump($listApplications);

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('SparrowPlatformBundle:Advert:view.html.twig', array(
          'advert' => $advert,
          'listApplications' => $listApplications
        ));
        
    }
     
    public function addAction(Request $request)
    {
        
         // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        
        $advert = new Advert();
        $advert->setTitle('Recherche développeur Angular JS.');
        $advert->setAuthor('Alex');
        $advert->setContent("Nous recherchons un développeur Angular débutant sur LA. Blabla…");
        
        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('https://en.wikipedia.org/wiki/Angular_(application_platform)#/media/File:Angular_full_color_logo.svg');
        $image->setAlt('Angular');

        // On lie l'image à l'annonce
        $advert->setImage($image);
        
        // Création d'une première candidature
        $application = new Application();
        $application ->setAuthor('Toto');
        $application ->setContent("Je suis chaud!");

        // On lie les candidatures à l'annonce
        $application->setAdvert($advert);
        
        // On récupère toutes les compétences possibles
        $listSkills = $em->getRepository('SparrowPlatformBundle:Skill')->findAll();

        // Pour chaque compétence
        foreach ($listSkills as $skill) {
          // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
          $advertSkill = new AdvertSkill();

          // On la lie à l'annonce, qui est ici toujours la même
          $advertSkill->setAdvert($advert);
          
          // On la lie à la compétence, qui change ici dans la boucle foreach
          $advertSkill->setSkill($skill);

          // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
          $advertSkill->setLevel('Expert');

          // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
          $em->persist($advertSkill);
        }

        // Étape 1 : On « persiste » les entités
        $em->persist($advert);
        $em->persist($image);
        $em->persist($application);
        
        

        $em->flush();

        // Reste de la méthode qu'on avait déjà écrit
        if ($request->isMethod('POST')) {
          $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

          // Puis on redirige vers la page de visualisation de cettte annonce
          return $this->redirectToRoute('sparrow_platform_view', array('id' => $advert->getId()));
        }

        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('SparrowPlatformBundle:Advert:add.html.twig', array('advert' => $advert));
    }
    
     public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      // On récupère l'annonce $id
      $advert = $em->getRepository('SparrowPlatformBundle:Advert')->find($id);

      if (null === $advert) {
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }

      // La méthode findAll retourne toutes les catégories de la base de données
      $listCategories = $em->getRepository('SparrowPlatformBundle:Category')->findAll();

      // On boucle sur les catégories pour les lier à l'annonce
      foreach ($listCategories as $category) {
        $advert->addCategory($category);
      }

      $em->flush();
      
      return $this->render('SparrowPlatformBundle:Advert:edit.html.twig', array(
          'id' => $id,
          'advert' => $advert
      ));

    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $advert = $em->getRepository('SparrowPlatformBundle:Advert')->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        // On boucle sur les catégories de l'annonce pour les supprimer
        foreach ($advert->getCategories() as $category) {
          $advert->removeCategory($category);
        }

        $em->flush();

        return $this->render('SparrowPlatformBundle:Advert:delete.html.twig');
    }
    
    public function menuAction()
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 1, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('SparrowPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
    
  }
    //----------------------------------------------------------------------------------------------------------
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }
    
    public function helloAction(){
        
        $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:hello.html.twig');
        
        return new Response($content);
    }
    
    public function leaveAction(){
        
        $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:leave.html.twig');
        
        return new Response($content);
    }
}

