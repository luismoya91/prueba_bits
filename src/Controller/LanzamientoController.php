<?php

namespace App\Controller;

use App\Models\Lanzamiento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;


class LanzamientoController extends AbstractController
{
    public function index(LoggerInterface $logger): Response
    {

        $lanzamiento = new Lanzamiento($logger);
        $albums = $lanzamiento->getReleases($this->getParameter('app.client_id'),$this->getParameter('app.cliente_secret'));

        
        return $this->render('lanzamiento.html.twig', ['albums' => $albums]);
    }

}