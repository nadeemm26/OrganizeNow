<?php
// Import necessary libraries
require 'vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Home page
$app->get('/', function ($request, $response, $args) {
    $events = [
        ['id' => 1, 'title' => 'Concert', 'date' => '2023-12-01', 'location' => 'Stadium'],
        ['id' => 2, 'title' => 'Art Exhibition', 'date' => '2023-12-05', 'location' => 'Gallery'],
    ];
    $response->getBody()->write(json_encode($events));
    return $response->withHeader('Content-Type', 'application/json');
});

// Event details page
$app->get('/event/{id}', function ($request, $response, $args) {
    $eventId = $args['id'];
    $eventDetails = [
        1 => ['title' => 'Concert', 'date' => '2023-12-01', 'location' => 'Stadium', 'description' => 'A live concert featuring various artists.'],
        2 => ['title' => 'Art Exhibition', 'date' => '2023-12-05', 'location' => 'Gallery', 'description' => 'An exhibition showcasing local artists.'],
    ];
    
    if (isset($eventDetails[$eventId])) {
        $response->getBody()->write(json_encode($eventDetails[$eventId]));
    } else {
        $response->getBody()->write(json_encode(['error' => 'Event not found']));
    }
    return $response->withHeader('Content-Type', 'application/json');
});

// Booking form
$app->post('/book/{id}', function ($request, $response, $args) {
    $eventId = $args['id'];
    $data = json_decode($request->getBody(), true);
    
    // Here you would typically save the booking details to a database
    // For demonstration, we will just return the received data
    return $response->withJson([
        'eventId' => $eventId,
        'name' => $data['name'],
        'email' => $data['email'],
        'tickets' => $data['tickets'],
        'message' => 'Booking successful!'
    ]);
});

$app->run();
