<?php

namespace Sparrow\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class AdvertController extends Controller
{
    public function indexAction($page)
    {
        //Génération d'URL
        /*$url = $this->get('router')->generate(
            'sparrow_platform_view', 
            array('id' => 5),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
          $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:index.html.twig', array('name' => 'Sparrow','firstname' => 'Dave', 'url' => $url));
        
        return new Response($content); */
        
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
        //Récupération de tag URL et renvoie d'une réponse (Request $request en argument) 
        /*$tag = $request->query->get('tag');

         return $this->get('templating')->renderResponse(
           'SparrowPlatformBundle:Advert:view.html.twig',
            array('id'  => $id, 'tag' => $tag)
         ); */

        //Faire une redirection (Ne pas oublier le "use")
        /* $url = $this->get('router')->generate('sparrow_platform_home');

        return new RedirectResponse($url); */

        //Faire une redirection (Pas besoin du "use")
        /*$url = $this->get('router')->generate('sparrow_platform_home');

          return $this->redirect($url); */

        //Faire une redirection (Pas besoin du "use")
        //return $this->redirectToRoute('sparrow_platform_home');

        //Retourner une réponse en JSON ex:1
        /*$response = new Response(json_encode(array('id' => $id)));

        $response->headers->set('Content-Type', 'application/json');

        return $response; */

        //return new JsonResponse(array('id' => $id));

        //variables de session
        // Récupération de la session
        /*$session = $request->getSession();

        // On récupère le contenu de la variable user_id
        $userId = $session->get('user_id');

        // On définit une nouvelle valeur pour cette variable user_id
        $session->set('user_id', 91);

        // On n'oublie pas de renvoyer une réponse
        return new Response("<body>Je suis une page de test, je n'ai rien à dire</body>"); */
        $advert = array(
            'title'   => 'Recherche développpeur Symfony2',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
          );

          return $this->render('SparrowPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert
          ));
        
    }
     
    public function addAction(Request $request)
    {
      //Utilisation de la session pour les messages flashs 
      /*$session = $request->getSession();

      $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

      // Le « flashBag » est ce qui contient les messages flash dans la session
      // Il peut bien sûr contenir plusieurs messages :
      $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');

      // Puis on redirige vers la page de visualisation de cette annonce
      return $this->redirectToRoute('sparrow_platform_view', array('id' => 5)); */
        
       if ($request->isMethod('POST')) {
           $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
           return $this->redirectToRoute('sparrow_platform_view', array('id' => 5));
       }

       return $this->render('SparrowPlatformBundle:Advert:add.html.twig');
    }
    
    public function editAction($id, Request $request)
    {
    
      if ($request->isMethod('POST')) {
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
        return $this->redirectToRoute('oc_platform_view', array('id' => 5));
      }
      
      $advert = array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => $id,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()
      );

      return $this->render('SparrowPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
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

