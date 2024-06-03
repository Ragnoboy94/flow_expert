<?php

namespace App\Imports;


use App\Models\MedicineRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Symfony\Component\DomCrawler\Crawler;

class MedicinesRowsImport implements ToModel
{
    protected $offerId;

    public function __construct(int $offerId)
    {
        $this->offerId = $offerId;
    }

    public function model(array $row)
    {
        if ((int)$row[0] > 0 && isset($row[6]) && !empty($row['1'])) {
            $existingRow = MedicineRows::where('trade_name', $this->cleanString($row['3']))->first();
            if ($existingRow && !is_null($existingRow->online_price)) {
                $online_price = $existingRow->online_price;
            } else {
                $online_price = $this->getMinPrice($this->cleanString($row['3']));
            }
            return new MedicineRows([
                'offer_id' => $this->offerId,
                'mnn' => $this->cleanString($row['1']),
                'name' => $this->cleanString($row['2']),
                'trade_name' => $this->cleanString($row['3']),
                'quantity' => (int)$row['4'],
                'price' => (float)$row['5'],
                'total' => (float)$row['6'],
                'online_price' => (float)$online_price
            ]);
        }
    }
    protected function cleanString($value)
    {
        // Замена переносов строк на пробелы
        return str_replace(["\r", "\n"], ' ', $value);
    }
    private function getMinPrice(string $drugName): int|float
    {
        if (!$drugName) {
            return 0;
        }

        $prices = $this->parseGoogle($drugName);

        if (empty($prices)) {
            return 0;
        }

        return $this->calculateAveragePrice($prices);

    }

    private function fetchHtml($url)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->getRandomUserAgent()
            ])->get($url);
            return $response->body();
        } catch (\Exception $e) {
            // Обработка ошибок
            return '';
        }
    }

    private function getRandomUserAgent()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:53.0) Gecko/20100101 Firefox/53.0',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0'
        ];

        return $userAgents[array_rand($userAgents)];
    }

    private function parseGoogle($drugName)
    {
        $url = "https://www.google.com/search?q=" . urlencode($drugName . " цена");
        $html = $this->fetchHtml($url);
        if (empty($html)) return [];

        $crawler = new Crawler($html);

        return $crawler->filterXPath("//span[contains(text(), '₽')]")->each(function ($node) {
            $priceText = $node->text();
            $price = preg_replace('/[^0-9,]/', '', $priceText);
            $price = str_replace(',', '.', $price);
            return floatval($price);
        });
    }
    private function calculateAveragePrice($prices)
    {
        if (count($prices) === 0) return 0;
        return array_sum($prices) / count($prices);
    }
}
