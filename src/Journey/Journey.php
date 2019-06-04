<?php
namespace Src\Journey;
use Src\BoardingCard\BoardingCard;
use Exception;
class Journey implements \Countable, \Iterator, \ArrayAccess
{
    /**
     *
     * @var array
     */
    private $boardingCards = [];
    
    /**
     *
     * @var int
     */
    private $position = 0;
    
    /**
     *
     * @var int 
     */
    private $startedDestination = -1;
    
    /**
     *
     * @var int 
     */
    private $startedOffset = -1;
    
    
    /**
     * Construct function for BoardingCard object. 
     * @param BoardingCard $value
     */
    public function __construct(BoardingCard $value )
    {
        $this->offsetSet(0, $value);
    }
    
    /**
     * 
     * @param string $name
     * @return type
     */
    public function __get($name) {
        
        return $this->$name;
    }

    /**
     * Get count of $boardinfCards array.  
     * @return int
     */
    public function count()
    {
        return count($this->boardingCards);
    }

    
    /**
     * Reset position by started point
     */
    public function rewind()
    {
        $this->position = $this->startedDestination;
    }

    /**
     * Returns current position.
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

   /**
    * Returns current Boarding Card object
    * @return \Src\BoardingCard\BoardingCard
    */
    public function current()
    {
        return $this->boardingCards[$this->position];
    }
    
    /**
     * Returns next boarding card. 
     * If next boarding card is not found then returns current boarding card.
     * @return \Src\BoardingCard\BoardingCard
     */
    public function next()
    {
        $next = array();
        $next = $this->getNextBoardingCard($this->current()->getArrival());
        if (!empty($next))
        {
            return $next;
        }
        else
        {
            return $this->current();
        }
    }
    /**
     * Checks the current boarding card's is set or not 
     * @return bool
     */
    public function valid()
    {
        return isset($this->boardingCards[$this->position]);
        
    }

    /**
     * Checks the  boarding card's is set or not by specified offset
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->boardingCards[$offset]);
    }

    /**
     * Get boarding card by specified offset. 
     * @param int $offset
     * @return \Src\BoardingCard\BoardingCard
     */
    public function offsetGet($offset)
    {
        return $this->boardingCards[$offset];
    }

    /**
     * Adds a BoardingCard object in boardingCards array
     * @param int $offset
     * @param BoardingCard $boardingCard
     * @throws Exception 
     */
    public function offsetSet($offset,$boardingCard)
    {
        if (!$boardingCard instanceof BoardingCard)
        {
            throw new Exception('Excepted type not setted');
        }
        
        if (empty($offset)) { 
            $this->boardingCards[] = $boardingCard;
        } else {
            $this->boardingCards[$offset] = $boardingCard;
        }
    }

    /**
     * Deletes BoardingCard object in boardinfCard array
     * @param type $offset
     */
    public function offsetUnset($offset):void
    {
        unset($this->boardingCards[$offset]);
    }
    
    /**
     * Reorder the boarding cards from start to end.
     * @return array 
     * @throws Exception 
     */
    public function orderBoardingCards():array
    {
        $temp = array();
        if (!empty($this->boardingCards))
        {
            $this->getStartedPoint();
            $temp[] = $this->current();
            $counter = $this->count()-1;
            for ($i = 0 ; $i<$counter; $i++)
            {
               $temp[] = $this->getNextBoardingCard($this->current()->getArrival());
            }
        }
        else {
            throw new Exception("There is no boarding cards for ordering operation.");
        }
        if (count($temp) == count($this->boardingCards))
        {
            $this->boardingCards = $temp;
            unset($temp);
        }
        return $this->boardingCards;
    }
    
    
    /**
     * Finds starting point which difference between departure and arrival points.
     * @throws Exception
     */
    private function getStartedPoint()
    {
        foreach ($this->boardingCards as $offset =>$boardindCard)
        {
           $tempDep[$offset] = $boardindCard->getDeparture()->getDestinationId();   
           $tempArr[$offset] = $boardindCard->getArrival()->getDestinationId(); 
        }
        
        $tempArr = array_flip($tempArr);
       
        foreach ($tempDep as $key => $value) {
            if(isset($tempArr[$value])) {
                unset($tempDep[$key]);
            }
        }
        
        if (is_array($tempDep)&& count($tempDep) == 1)
        {
            $this->startedOffset = key($tempDep);
            $this->startedDestination = reset($tempDep);
            $this->position = $this->startedOffset;
            unset($tempArr);
            unset($tempDep);
        }
        else
        {
            throw new Exception('Input values has no valid chain. It has more than one or no started point');
        }
    }
    
    /**
     * Until it ends finds next boarding card by current boarding cards arrival point and sets it to new position. 
     * @param \src\Destination\Destination $destination
     * @return BoardingCard
     */
    private function getNextBoardingCard(\src\Destination\Destination $destination): BoardingCard
    {
        if (!empty($destination))
        {
            $destinationId = $destination->getDestinationId();
            foreach ($this->boardingCards as $key => $value)
            {
                if($value->getDeparture()->getDestinationId() == $destinationId)
                {
                    $this->position = $key;
                    $this->offsetGet($key);
                    return $this->offsetGet($key);
                }                
            }
        }
        return $this->current();
    }   
}
