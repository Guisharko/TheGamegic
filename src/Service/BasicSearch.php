<?php
/**
 * Created by PhpStorm.
 * User: wilder4
 * Date: 31/01/19
 * Time: 14:12
 */

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicSearch
{
    private $uri = 'https://api.scryfall.com/cards/search?q=';
    private $url = '&unique=card&include_multilingual=true&format=image&sas=grid&order=name';
    private $urlPage = '&page=';


    public function basicSearchName(string $search, int $next=1)
    {
        $client = new Client([
            RequestOptions::HTTP_ERRORS => false,
        ]);
        $nameCard = $client->request('GET', $this->uri . $search . $this->url . $this->urlPage . $next);
        $statusCode = $nameCard->getStatusCode();
        if ($statusCode > 400) {
            $this->addFlash('danger', "Aucune carte ne correspond à votre recherche");
            return $this->redirectToRoute('homepage');
        }
        if (!empty(trim($search))) {
            return $this->redirectToRoute('searchpage', ['search' => $search, 'next' => $next,]);
        }
        $body = $nameCard->getBody();
        $json = json_decode($body->getContents(), true);
        return $json;
    }
}