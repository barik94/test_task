<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Click;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clicks = $em->getRepository('AppBundle:Click')->findAll();

        return $this->render('default/index.html.twig', ['clicks' => $clicks]);
    }

    /**
     * @Route("/click/", name="action_click")
     */
    public function clickAction(Request $request)
    {
        $ip = $request->getClientIp();
        $param1 = $request->query->get('param1');
        $param2 = $request->query->get('param2');
        $userAgent = $request->headers->get('User-Agent');
        $referer = $request->headers->get('referer');
        
        $em = $this->getDoctrine()->getManager();
        
        $click = $em->getRepository('AppBundle:Click')->find(md5($userAgent + $ip + $referer + $param1));
        
        if (!$click) {
            $click = new Click($userAgent, $ip, $referer, $param1, $param2);

            $em->persist($click);
            $em->flush();

            return $this->redirect($this->generateUrl('result_success', ['id' => $click->getId()]));
        }

        return $this->redirect($this->generateUrl('result_error', ['id' => $click->getId()]));
    }
    
    /**
     * @Route("/success/{id}", name="result_success")
     */
    public function successAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $click = $em->getRepository('AppBundle:Click')->find($id);

        if (!$click) {
            return new Response("Not found!", 404);
        }

        return new Response($click, 200);
    }

    /**
     * @Route("/error/{id}", name="result_error")
     */
    public function errorAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $click = $em->getRepository('AppBundle:Click')->find($id);

        if (!$click) {
            return new Response("Not found!", 404);
        }
        
        if ($em->getRepository('AppBundle:BadDomain')->findOneByDomain($click->getReferrer())) {
            $click->thisDomainIsBad();
        }

        $click->incrementError();

        $em->persist($click);
        $em->flush();

        $response = new Response("Repeated click!", 400);
        $response->headers->set('Refresh', '5; url=http://google.com/');

        return $response;
    }
}
