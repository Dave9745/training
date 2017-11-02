<?php

namespace Sparrow\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MainController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CoreBundle:Main:index.html.twig');
    }
    
    
    //Fonction d'exercice sur la génération d'URL
    public function generationAction()
    {
        $url = $this->get('router')->generate(
            'sparrow_core_generated', 
            array('id' => 5),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
          $content = $this->get('templating')->render('CoreBundle:Main:generation.html.twig', array('url' => $url));
        
        return new Response($content); 
       
    }
    
    
    //Fontion de la page servant à la génération d'URL
    public function generatedAction()
    {
        return $this->render('CoreBundle:Main:generated.html.twig');
    }
    
    
    //Fonction d'exercice sur l'antispam
    public function antispamAction(Request $request)
    {
        $antispam = $this->container->get('sparrow_core.antispam');

        $text = $request->query->get('tag');
        
        if($text != ''){
            if ($antispam->isSpam($text)) {
                throw new \Exception('Votre message a été détecté comme spam !');
            }else{
                return $this->render('CoreBundle:Main:antispam.html.twig', array('text' => $text));
            }
        }else{
            return new Response('Pour continuer ajoutez un tag à l\'URL (?tag=nomDuTag). Il peut s\'agir de tout et de rien');
        }
    }
    
    //Fonction d'exercice sur la redirection
    public function redirectAction(Request $request){
        
        $session = $request->getSession();

        $session->getFlashBag()->add('info', '-- Vous avez été redirigé vers la page d\'accueil');

        return $this->redirectToRoute('core_homepage');
        
    }
    
    //Fonction d'exercice sur le renvoi de "json"
    public function jsonAction(Request $request){
        
        $text = $request->query->get('tag');
        
        if($request != ''){
            
            $response = new Response(json_encode(array('tag' => $text)));
            
            $response->headers->set('Content-Type', 'application/json');

            return $response; 
        
        }else{
            
            $response = new Response(json_encode(array('tag' => 'null')));
            
            $response->headers->set('Content-Type', 'application/json');

            return $response; 
        }   
        
    }
        
    //Fonction de l'exercice du cours
    public function courseAction(Request $request){
        
        $session = $request->getSession();

        $session->getFlashBag()->add('I', '-- La page de contact n’est pas encore disponible');

        return $this->redirectToRoute('core_homepage');
        
    }
        
}
