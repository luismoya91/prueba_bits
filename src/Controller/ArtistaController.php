<?php

namespace App\Controller;

use App\Models\Artista;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;


class ArtistaController extends AbstractController
{
    /**
     * @Route("/artista/{id}", name="artista")
     */
    public function index(string $id,LoggerInterface $logger): Response
    {

        $artista = new Artista($logger);
        $artist_info = $artista->getArtistInfo($this->getParameter('app.client_id'),$this->getParameter('app.cliente_secret'), $id);
        return $this->render('artista.html.twig', ['artista_info' => $artist_info]);
    }

}