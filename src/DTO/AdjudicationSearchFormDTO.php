<?php

namespace App\DTO;

use App\Entity\Cemetery;
use App\Entity\Grave;
use App\Entity\Owner;

class AdjudicationSearchFormDTO
{

   private ?Cemetery $cemetery = null;
   private ?Owner $owner = null;
   private ?Grave $grave = null;
   private ?bool $expired = null;

   public function getCemetery(): ?Cemetery
   {
      return $this->cemetery;
   }

   public function setCemetery(?Cemetery $cemetery): self
   {
      $this->cemetery = $cemetery;

      return $this;
   }

   public function getOwner(): ?Owner
   {
      return $this->owner;
   }

   public function setOwner(?Owner $owner): self
   {
      $this->owner = $owner;

      return $this;
   }

   public function getGrave(): ?Grave
   {
      return $this->grave;
   }

   public function setGrave(?Grave $grave):self
   {
      $this->grave = $grave;

      return $this;
   }

   public static function fill(array $criteria) : self 
   {
      $filter = new AdjudicationSearchFormDTO();
      $cemetery = isset($criteria['cemetery']) ? $criteria['cemetery'] : null; 
      $owner = isset($criteria['owner']) ? $criteria['owner'] : null; 
      $grave = isset($criteria['grave']) ? $criteria['grave'] : null; 
      $expired = isset($criteria['expired']) ? $criteria['expired'] : null; 
      $filter->setCemetery($cemetery);
      $filter->setOwner($owner);
      $filter->setGrave($grave);
      return $filter;
   }

   public function toArray(): array 
   {
      $array = [];
      $array['cemetery'] = $this->cemetery;
      $array['owner'] = $this->owner;
      $array['grave'] = $this->grave;
      $array['expired'] = $this->expired;
      return $array;
   }

   public function getExpired(): ?bool
   {
      return $this->expired;
   }

   public function setExpired(?bool $expired) : self
   {
      $this->expired = $expired;

      return $this;
   }
}
