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
        
         if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
         }
         
         return $this->render('SparrowPlatformBundle:Advert:index.html.twig');
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
        
        return $this->render('SparrowPlatformBundle:Advert:view.html.twig', array(
            'id' => $id
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

       return $this->render('SparrrowPlatformBundle:Advert:add.html.twig');
    }
    
    public function editAction($id, Request $request)
    {
    
      if ($request->isMethod('POST')) {
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
        return $this->redirectToRoute('oc_platform_view', array('id' => 5));
      }

      return $this->render('SparrowPlatformBundle:Advert:edit.html.twig');
    }

    public function deleteAction($id)
    {
      return $this->render('SparrowPlatformBundle:Advert:delete.html.twig');
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

