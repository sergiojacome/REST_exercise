<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/faker', function (Request $request, Response $response) {
    $faker = Faker\Factory::create('en_US');
    for ($i=0; $i < 10; $i++) {
        echo '<p>'.$faker->username;
        echo '<br>'.$faker->email;
        echo '<br>'.$faker->password;
        echo '<br>'.$faker->city;
        echo '<br>'.$faker->stateAbbr;
        echo '<br>'.$faker->postcode;
        echo '<br>'.$faker->countryCode;
        echo '<br>'.$faker->text($maxNbChars = 280);
        echo '</p>';
    }
});