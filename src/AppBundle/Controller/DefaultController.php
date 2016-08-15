<?php

namespace AppBundle\Controller;

use DateTime;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('Default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }
    public function getTimeToMicroseconds() {
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

        return $d->format("Y-m-d H:i:s.u");
    }
    /**
     * @Route("/random_user.{_format}",
     *     name="randomUser",
     *     defaults={"_format": "json"},
     *     requirements={"_format": "json|html"})
     *
     * @Rest\View()
     */
    public function randomUserAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $userRepository = $em->getRepository("AppBundle:User");

        $user = $userRepository->find(rand(1, 2000002));

        // replace this example code with whatever you need
        return ['user' => $user];
    }
}
