<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Lcobucci\JWT\Parser;

$app->get('/faker/{howMany}', function (Request $request, Response $response) {
    $token = (new Parser())->parse((string) $_COOKIE['token']);
    $howMany = $request->getAttribute('howMany');
    $faker = Faker\Factory::create('en_US');
    //echo $token->getClaim('isthisok');
    for ($i=0; $i < $howMany; $i++) {
        $first_name = $faker->firstName($gender = null|'male'|'female');
        $last_name = $faker->lastName;
        $phone = $faker->phoneNumber;
        $email = $faker->email;
        $address = $faker->streetAddress;
        $city = $faker->city;
        $state = $faker->state;
        
        $sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state) VALUES
        (:first_name,:last_name,:phone,:email,:address,:city,:state)";

        try{
            // Get DB Object
            $db = new db($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            // Connect
            $db = $db->connect();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name',  $last_name);
            $stmt->bindParam(':phone',      $phone);
            $stmt->bindParam(':email',      $email);
            $stmt->bindParam(':address',    $address);
            $stmt->bindParam(':city',       $city);
            $stmt->bindParam(':state',      $state);

            $stmt->execute();
            
            echo '{"notice": {"text": "Customer Added"}';

        } catch(PDOException $e){
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    }
});