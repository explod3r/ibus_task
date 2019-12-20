<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use duzun\hQuery;

class ScraperController extends AbstractController
{
    /**
     * @Route("/api/scraper", name="home")
     */
    public function index()
    {
        $offers = $this->scrapData();
        $response = new \stdClass();

        foreach ($offers as $key => $o) {
            $title = $o->find('.media-heading');
            $location = $o->find('.location');
            $date = $o->find('.date');

            $content = trim($o->find('article')->text());
            $content = preg_replace('/\s\s+/', ' ', $content);

            $apply_link = $o->find('p > a')->attr('href');

            $response->offers[] = [
                'title' => !is_null($title) ? trim($title->text()) : null,
                'location' => !is_null($location) ? trim($location->text()) : null,
                'date' => !is_null($date) ? trim($date->text()) : null,
                'content' => !is_null($content) ? $content : null,
                'apply_link' => !is_null($apply_link) ?  $apply_link : null,
            ];
        }

        return new Response(json_encode($response, JSON_PRETTY_PRINT));
    }

    public function scrapData()
    {
        $opts = [
              'http'=>[
                'method'=>"GET"
            ]
        ];

        $context = stream_context_create($opts);

        $doc = hQuery::fromURL('http://www.ibusmedia.com/career.htm', false, $context);
        $offers = $doc->find('.career > div');

        return $offers;
    }
}
