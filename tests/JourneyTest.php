<?php

/**
 * Test functions for Journey operations. 
 * This includes core functions tests for this api.
 */
namespace Tests;
use Src\BoardingCard\AirWayBoardingCard;
use Src\BoardingCard\HighWayBoardingCard;
use Src\BoardingCard\RailWayBoardingCard;
use Src\Destination\Destination;
use Src\Baggage\Baggage;
use Src\Baggage\BaggageType;
use Src\Journey\Journey;
use src\TransportationType\TransportationType;
use Tests\JourneyTest;
use PHPUnit\Framework\TestCase;
use Src\BoardingCard\BoardingCard;

class JourneyTest extends TestCase
{
    /**
     * Gets started point(by destinationId field) for unordered journey data that includes boarding cards.
     */
    public function testGetStartedPoint()
    {
        $journey = $this->prepareJourneyData();
        $class = new \ReflectionClass($journey);
        $method = $class->getMethod('getStartedPoint');
        $method->setAccessible(true);
        $method->invoke($journey);
        $startedDestination = $class->getProperty('startedDestination');
        $startedDestination->setAccessible(true);
        $this->assertEquals($startedDestination->getValue($journey), 8342);
    }
    
    /**
     * This function test for finds next boarding card id. 
     * Our test journey datas first element is $b ($boardingCardId = 848458, $destinationId =2349) variable. 
     */
    public function testNextBoardingCard()
    {
        $journey = $this->prepareJourneyData();
        $next = $journey->next();
        $this->assertEquals($next->getBoardingCardId(),75999);
    }
    
    /**
     * Test functions for ordered boarding cards. 
     * Checks prepared unordered list with ordered list boardingCardId fields. 
     */
    public function testOrderedBoardingCards()
    {
        $journey = $this->prepareJourneyData();
        $journey->orderBoardingCards();
        $expectedOrderedData = [848474,848458,75999,43242,848424];
        $counter = $journey->count();
        for ($i = 0; $i<$counter; $i++)
        {
            $currentOrderedData[] = $journey->offsetGet($i)->getBoardingCardId();
        }        
        $this->assertEquals($currentOrderedData,$expectedOrderedData);
    }
    
    /**
     * This function prepare journey data which specified in the  tasks document. 
     * Also, data prepared as unordered.  
     * @return Journey
     */
    private function prepareJourneyData(): Journey
    {
        $tpTrain = new TransportationType(1, 'Train');
        $tpBus = new TransportationType(2, 'Bus');
        $tpFlight = new TransportationType(3, 'Flight');
        $passenger = 'ANIL AÇIKGOZ';
        $reference = 'JI002';
        $b = new HighWayBoardingCard(848458, new Destination(7564, 'Lviv', $tpBus), new Destination(2349, 'Lviv Danylo Halytskyi Airport', $tpBus), $passenger, $reference, '48', 'A');
        $e = new AirWayBoardingCard(75999, new Destination(2349, 'Lviv Danylo Halytskyi Airport', $tpFlight), new Destination(4531, 'Stokholm', $tpFlight), $passenger, $reference, 'BF134', '3A', '45B', new Baggage(344, new BaggageType(1, 'TRANSFER'), 1));
        $d = new AirWayBoardingCard(43242, new Destination(4531, 'Stokholm', $tpFlight), new Destination(9310, 'Amsterdam Schiphol', $tpFlight), $passenger, $reference, 'SK22', '7B', '18', new Baggage(344, new BaggageType(1, 'TRANSFER'), 1));     
        $a = new RailWayBoardingCard(848474, new Destination(8342, 'Kiev', $tpTrain), new Destination(7564, 'Lviv', $tpTrain), $passenger, $reference, 'X12', '18C', '3A');
        $c = new RailWayBoardingCard(848424, new Destination(9310, 'Amsterdam Schiphol', $tpTrain), new Destination(2952, 'Rotterdam', $tpTrain), $passenger, $reference, 'T13', '12B', '1A');
        $journey = new Journey($b);
        $journey->offsetSet(1, $a);
        $journey->offsetSet(2, $e);
        $journey->offsetSet(3, $c);
        $journey->offsetSet(4, $d);
        return $journey;
    }
}
