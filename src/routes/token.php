<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

$app->get('/token', function (Request $request, Response $response) {
    $signer = new Sha256();
    
    $token = (new Builder())->setIssuer('http://localhost:8080') // Configures the issuer (iss claim)
                            ->setAudience('http://localhost:8080') // Configures the audience (aud claim)
                            ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                            //->setNotBefore(time() + 6000) // Configures the time that the token can be used (nbf claim)
                            ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                            ->set('uid', 1) // Configures a new claim, called "uid"
                            ->set('isthisok','yes')
                            ->sign($signer, 'supersecretkeyyoushouldnotcommittogithub') // creates a signature using "testing" as key
                            ->getToken(); // Retrieves the generated token
    setcookie('token', $token, time() + (86400 * 30), "/"); // 86400 = 1 day
    echo $token;
});