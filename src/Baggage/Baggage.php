<?php

namespace Src\Baggage;
/**
 * 
 */
class Baggage 
{
    private $baggageType;
    private $baggageId;
    private $baggeCount;
    
    /**
     * Construct function for baggage object.
     * @param int $baggeId
     * @param \Src\Baggage\BaggageType $baggeType
     * @param int $baggeCount
     */
    public function __construct(int $baggeId, BaggageType $baggeType, int $baggeCount) {
        
        $this->baggageType = $baggeType;
        $this->baggageId = $baggeId;
        $this->baggeCount = $baggeCount;
    }
    
    /**
     * Setter function for baggegeType.
     * @param \Src\Baggage\BaggageType $baggeType
     */
    public  function setBaggageType (BaggageType $baggeType):void
    {
        $this->baggageType = $baggeType;
    }
    
    /**
     * Setter function for baggegeId
     * @param int $baggageId
     */
    public function setBaggageId(int $baggageId):void
    {
        $this->baggageId = $baggageId;
    }
    
    /**
     * Setter function for baggegeCount.
     * @param int $baggageCount
     */
    public function setBaggeCount(int $baggageCount):void
    {
        $this->baggeCount = $baggageCount;
    }
    
    /**
     * Getter function for baggage type. 
     * @return \Src\Baggage\BaggeType
     */
    public  function getBaggageType ():BaggeType
    {
        return $this->baggageType;
    }
    
    /**
     * Gettter function for baggegeId
     * @return int
     */
    public function getBaggageId():int
    {
        return $this->baggageId;
    }
    
    /**
     * Gettter function for baggageCount
     * @return int
     */
    public function getBaggeCount():int
    {
        return $this->baggeCount;
    }    
}