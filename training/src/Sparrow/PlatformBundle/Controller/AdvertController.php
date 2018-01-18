<?php

namespace Sparrow\PlatformBundle\Controller;

use Sparrow\PlatformBundle\Entity\Advert;
use Sparrow\PlatformBundle\Entity\Image;
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
        
        // On récupère le repository
        $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('SparrowPlatformBundle:Advert')
        ;

        // On récupère l'entité correspondante à l'id $id
        $advert = $repository->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('SparrowPlatformBundle:Advert:view.html.twig', array(
          'advert' => $advert
        ));
        
    }
     
    public function addAction(Request $request)
    {
        
        $advert = new Advert();
        $advert->setTitle('Recherche développeur Symfony.');
        $advert->setAuthor('Jack');
        $advert->setContent("Nous recherchons un développeur symfony débutant sur LA. Blabla…");
        
        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        // On lie l'image à l'annonce
        $advert->setImage($image);
        
        // On peut ne pas définir ni la date ni la publication,
        // car ces attributs sont définis automatiquement dans le constructeur

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » les entités
        $em->persist($advert);

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
    

    public function deleteAction($id)
    {
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

