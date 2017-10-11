<?php

namespace Sparrow\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:index.html.twig', array('name' => 'Sparrow',
                                                                                                           'firstname' => 'Dave'));
        return new Response($content);
    }
    
     public function viewAction($id)
     {
          return new Response("Ad number : ".$id);
     }
     
     public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }
    
    //----------------------------------------------------------------------------------------------------------
    
    public function helloAction(){
        
        $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:hello.html.twig');
        
        return new Response($content);
    }
    
    public function leaveAction(){
        
        $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:leave.html.twig');
        
        return new Response($content);
    }
}

