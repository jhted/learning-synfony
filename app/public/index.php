<?php

// use App\Kernel;
// use Symfony\Component\Dotenv\Dotenv;
// use Symfony\Component\ErrorHandler\Debug;
// use Symfony\Component\HttpFoundation\Request;

// require dirname(__DIR__).'/vendor/autoload.php';

// (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

// if ($_SERVER['APP_DEBUG']) {
//     umask(0000);

//     Debug::enable();
// }

// $kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
// $request = Request::createFromGlobals();
// $response = $kernel->handle($request);
// $response->send();
// $kernel->terminate($request, $response);



// ----------------   This is cours code     ------------------------ 

require __DIR__.'/../vendor/autoload.php';

use App\Format\FromStringInterface;
use App\Format\JSON;
use App\Format\XML;
use App\Format\YAML;
// use App\Format\BaseFormat;


$data = [
    "name" => "Teddy",
    "surname" => "Morwasetla"
];


$json = new JSON($data);
$xml = new XML($data);
$yml = new YAML($data);
// $baseformat = new BaseFormat($data);


$formats = [$json,$xml,$yml];

foreach ($formats as $format) {
    echo "<br>";
    echo "<br>";
    echo get_class($format);
    echo "<br>";
    var_dump($format->convert());
    echo "<br>";
    if ($format instanceof FromStringInterface ) {
        var_dump($format->convertFromString('{"name":"thabang","surname":"morwasetla"}'));
    }
}


// var_dump("<br>");
// var_dump($json->conv());