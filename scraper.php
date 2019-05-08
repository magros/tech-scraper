<?php
require 'vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$scrapSite = function ($url, $filters, $savFile = false) use ($client) {
    $crawler = $client->request('GET', $url);
    if (!is_array($filters)) {
        $filters = [$filters];
    }
    $result = [];
    foreach ($filters as $filter) {
        $result = array_merge($crawler->filter($filter)->extract('_text'), $result);
    }

    $result = array_map(function ($e) {
        return trim($e);
    }, $result);

    if ($savFile) {
        $arr = explode('/', "{$url}.txt");
        $name = end($arr);
        file_put_contents($name, implode($result, PHP_EOL));
    }
    return $result;
};

$generateFile = true;

$items = $scrapSite('https://en.wikipedia.org/wiki/List_of_programming_languages', '.div-col ul > li', $generateFile);
$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/Comparison_of_JavaScript_frameworks', '#mw-content-text > div > table:nth-child(7) tbody .table-rh a', $generateFile)
);
$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/List_of_Java_frameworks', '#mw-content-text > div > table tr td:first-child a', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://es.wikipedia.org/wiki/Framework_de_CSS', '#mw-content-text > div > ul:nth-child(14) li a', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/Category:PHP_frameworks', '#mw-pages > div a', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/Category:Python_web_frameworks', '#mw-pages > div > div a', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/List_of_CLI_languages', '#mw-content-text > div > ul:nth-child(6) b', $generateFile)
);


$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/List_of_relational_database_management_systems', '#mw-content-text > div > div.div-col.columns.column-width ul li a', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://spring.io/understanding/NoSQL', '#file > article > ul a', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://es.wikipedia.org/wiki/Anexo:Software_ERP', [
        '#mw-content-text > div > table:nth-child(3) tr td:first-child',
        '#mw-content-text > div > table:nth-child(5) tr td:first-child'
    ], $generateFile)
);


$items = array_merge(
    $items,
    $scrapSite('https://es.wikipedia.org/wiki/Anexo:Distribuciones_Linux', '#mw-content-text > div > table tr td:nth-child(2)', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/Comparison_of_CRM_systems', '#mw-content-text > div > table:nth-child(5) tr td:first-child', $generateFile)
);

$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/List_of_content_management_systems',
        [
            '#mw-content-text > div > table:nth-child(8) tr td:first-child',
            '#mw-content-text > div > table:nth-child(12) tr td:first-child',
            '#mw-content-text > div > table:nth-child(14) tr td:first-child',
            '#mw-content-text > div > table:nth-child(16) tr td:first-child',
            '#mw-content-text > div > table:nth-child(18) tr td:first-child',
            '#mw-content-text > div > table:nth-child(20) tr td:first-child',
            '#mw-content-text > div > table:nth-child(22) tr td:first-child',
            '#mw-content-text > div > table:nth-child(24) tr td:first-child',
            '#mw-content-text > div > table:nth-child(26) tr td:first-child'
        ], $generateFile)
);


$items = array_merge(
    $items,
    $scrapSite('https://en.wikipedia.org/wiki/Category:Amazon_Web_Services', '#mw-pages > div > div a', $generateFile)
);

file_put_contents('dictionary.txt', implode($items, PHP_EOL));

print_r($items);

