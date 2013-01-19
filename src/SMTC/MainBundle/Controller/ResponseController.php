<?php

namespace SMTC\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @Route("/respuesta")
 */
class ResponseController extends Controller
{
    /**
     * @Route("/response", name="responses_response")
     */
    public function responseAction()
    {
        return new Response('Respuesta simple!');
    }

    /**
     * @Route("/redirect", name="responses_redirect")
     */
    public function redirectAction()
    {
        return new RedirectResponse($this->generateUrl('examples_responses'));
    }

    /**
     * @Route("/json", name="responses_json")
     */
    public function jsonResponseAction()
    {
        return new JsonResponse(array(
            'class' => '\Symfony\Component\HttpFoundation\JsonResponse',
            'type'  => 'json'
        ));
    }

    /**
     * @Route("/jsonp", name="responses_jsonp")
     */
    public function jsonpResponseAction()
    {
        $response = new JsonResponse(array(
            'class' => '\Symfony\Component\HttpFoundation\JsonResponse',
            'type'  => 'jsonp'
        ));
        $response->setCallback('handleData');

        return $response;
    }

    /**
     * @Route("/streamed", name="responses_streamed")
     */
    public function streamedResponseAction()
    {
        $response = new StreamedResponse();
        $response->setCallback(function () {
            echo 'Loading';
            flush();
            ob_flush();
            for ($i=0; $i < 10; $i++) {
                usleep(200000);
                echo '.';
                flush();
                ob_flush();
            }
            echo 'Completed!';
            flush();
            ob_flush();
        });

        return $response;
    }
}
