<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?\DateTime $bookingDate = null;
    #[ORM\Column]
    private ?int $truckId = null;

      public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDate(): ?\DateTime
    {
        return $this->bookingDate;
    }

    public function setBookingDate(?\DateTime $bookingDate): void
    {
        $bookingDate->setTime(0,0,0);
        $this->bookingDate = $bookingDate;
    }

    public function getTruckId(): ?int
    {
        return $this->truckId;
    }

    public function setTruckId(?int $truckId): void
    {
        $this->truckId = $truckId;
    }
}
