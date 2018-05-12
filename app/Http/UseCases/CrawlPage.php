<?php

namespace App\Http\UseCases;

use Illuminate\Support\Facades\Storage;
use Goutte;

class CrawlPage
{
    private $url;
    private $response;
    private $counter;
    private $labels;
    private $crawler;

    /**
     * CrawlPage constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function handle()
    {

        $this->load();

        return $this->filter();

    }


    private function load()
    {
        $this->crawler = Goutte::request('GET', $this->url);

        $this->labels = ['time', 'expected', 'company', 'destination', 'gate', 'terminal', 'status', 'app'];

        $this->response = [];
        $this->counter = 0;

    }

    private function filter()
    {
        // filter each row
        $this->crawler->filter('.stylish-table__row.stylish-table__row--body')->each(function ($node)
        {
            // filter each cell
            $node->filter('.stylish-table__cell > div')->each(function($rowElement, $i)
            {
                if ($i == 3)
                {
                    $string = $rowElement->filter('span')->first()->text();
                }
                else
                {
                    $string = trim(preg_replace('/\s\s+/', ' ', $rowElement->text()));
                }

                // add to assoc array with label
                $this->response[$this->counter][$this->labels[$i]] = $string;
            });

            $this->counter++;

        });

        return $this->response;
    }
}