<?php
namespace Src\TransportationType;


class TransportationType
{
    /**
     *
     * @var int 
     */
    private $id;
    
    /**
     *
     * @var string 
     */
    private $name;
    
    /**
     * Construct function for TransportationType object. 
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name  = $name;
    }
    /**
     * Setter function for id.
     * @param int $id
     */
    public function setId(int $id):void
    {
        $this->id = $id;
    }
    /**
     * Setter function for name
     * @param string $name
     */
    public function setName(string $name):void
    {
        $this->name = $name;
    }
    /**
     * Getter function for id.
     * @return int
     */
    public function gettId():int
    {
        return $this->id ;
    }
    
    /**
     * Getter function for name. 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
}