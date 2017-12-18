<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once '../src/config/db.php';

$dotenv = new Dotenv\Dotenv('../');
$dotenv->load();

$app = new \Slim\App;

//JWT Middleware
$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret" => $_ENV['SECRET'],
    "path" => "/api",
    "error" => function ($request, $response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

//Token route
require_once '../src/routes/token.php';

// Customer Routes
require_once '../src/routes/customers.php';

$app->run();