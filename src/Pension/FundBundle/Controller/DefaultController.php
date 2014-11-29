<?php

namespace Pension\FundBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PensionFundBundle:Default:index.html.twig', array('name' => $name));
    }
}
