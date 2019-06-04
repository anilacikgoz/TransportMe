<?php
namespace App;    
require_once '..\src\AutoLoader\AutoLoader.php';

use Src\BoardingCard\AirWayBoardingCard;
use Src\BoardingCard\HighWayBoardingCard;
use Src\BoardingCard\RailWayBoardingCard;
use Src\Destination\Destination;
use Src\Baggage\Baggage;
use Src\Baggage\BaggageType;
use Src\Journey\Journey;
use src\TransportationType\TransportationType;




$tpTrain = new TransportationType(1, 'Train');
$tpBus = new TransportationType(2, 'Bus');
$tpFlight = new TransportationType(3, 'Flight');
$passenger = 'ANIL AÇIKGOZ';
$reference = 'JI002';



$a = new RailWayBoardingCard(848474, new Destination(7675, 'Kiev', $tpTrain), new Destination(7564, 'Lviv', $tpTrain), $passenger, $reference, 'X12', '18C', '3A');
$b = new HighWayBoardingCard(848458, new Destination(7564, 'Lviv', $tpBus), new Destination(2349, 'Lviv Danylo Halytskyi Airport', $tpBus), $passenger, $reference, '48', 'A');
$c = new AirWayBoardingCard(75999, new Destination(2349, 'Lviv Danylo Halytskyi Airport', $tpFlight), new Destination(4531, 'Stokholm', $tpFlight), $passenger, $reference, 'BF134', '3A', '45B', new Baggage(344, new BaggageType(1, 'TRANSFER'), 1));
$d = new AirWayBoardingCard(43242, new Destination(4531, 'Stokholm', $tpFlight), new Destination(9310, 'Amsterdam Schiphol', $tpFlight), $passenger, $reference, 'SK22', '7B', '18', new Baggage(344, new BaggageType(1, 'TRANSFER'), 1));     
$e = new RailWayBoardingCard(848424, new Destination(9310, 'Amsterdam Schiphol', $tpTrain), new Destination(2952, 'Rotterdam', $tpTrain), $passenger, $reference, 'T13', '12B', '1A');


$journey = new Journey($e);
$journey->offsetSet(1, $c);
$journey->offsetSet(2, $b);
$journey->offsetSet(3, $d);
$journey->offsetSet(4, $a);

$cards  = $journey->orderBoardingCards();

var_dump($cards);


