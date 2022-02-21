<?php

namespace App\Models;

use Psr\Log\LoggerInterface;
use SpotifyWebAPI;

class Artista {

    private  $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function getArtistInfo($key_app, $secret_app, $id_artist)
    {
        $api_authorized = $this->getAuth($key_app, $secret_app);
        try {
            
            $artist_info = $api_authorized->getArtists([
                $id_artist
            ]);

            $tracks = $api_authorized->getArtistTopTracks($id_artist, [
                'country' => 'se',
            ]);
            
            return [
                'artist_info' => $artist_info->artists[0],
                'tracks'      => $tracks->tracks
            ];

        } catch (\Throwable $th) {
            $this->logger->error("Error de Consulta de Información del artista : ".$th->getMessage());
            return false;
        }
    }

    public function getAuth(string $key, string $secret)
    {
        $spotifyWebAPI = new SpotifyWebAPI\SpotifyWebAPI();

        try {
            $session_data = (new SpotifyWebAPI\Session($key, $secret));

            try {
                $session_data->requestCredentialsToken();

                try {
                    $accessToken = $session_data->getAccessToken();

                    $spotifyWebAPI->setAccessToken($accessToken);

                    return $spotifyWebAPI;
                    
                } catch (\Throwable $thAccessToken) {
                    
                    $this->logger->error("Error de Acceso de Token : ".$thAccessToken->getMessage());
                    return false;
                }
            } catch (\Throwable $thRequest) {
                $this->logger->error("Error de Solicitud de Credenciales : ".$thRequest->getMessage());
                return false;
            }

        } catch (\Throwable $thSession) {
            $this->logger->error("Error de Inicio de Sesión : ".$thSession->getMessage());
            return false;
        }

    }

}