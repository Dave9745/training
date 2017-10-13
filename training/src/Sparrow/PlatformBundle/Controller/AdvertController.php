<?php

namespace Sparrow\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdvertController extends Controller
{
    public function indexAction()
    {
      
        $url = $this->get('router')->generate(
            'sparrow_platform_view', 
            array('id' => 5),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
          $content = $this->get('templating')->render('SparrowPlatformBundle:Advert:index.html.twig', array('name' => 'Sparrow','firstname' => 'Dave', 'url' => $url));
        
        return new Response($content);
    }
    
     public function viewAction($id, Request $request)
     {
          $tag = $request->query->get('tag');
          
          return new Response("Ad number : ".$id." with tag '".$tag."'");
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

