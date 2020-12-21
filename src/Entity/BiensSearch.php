<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class BiensSearch {

    /**
    * @var int|null
    */
    private $maxPrice;

    /**
    * @var int|null
    * @Assert\Range(min=10, max=400)
    */
    private $minSurface;

    /**
    * @var ArrayCollection
    * 
    */
    private $options;


    public function __construct() {
        $this->options = new ArrayCollection();

    }

    /**
    * @return int|null
    */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
    * @return int|null $maxPrice
    * @return BiensSearch
    */
    public function setMaxPrice(int $maxPrice): BiensSearch
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
    * @return int|null
    */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
    * @return int|null $minSurface
    * @return BiensSearch
    */
    public function setMinSurface(int $minSurface): BiensSearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }




    /**
    * @return ArrayCollection
    */
    public function getOptions(): ArrayCollection 
    {
        return $this->options;
    }

    /**
    * @param ArrayCollection $options
    * 
    */
    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;

       
    }
}