<?php

namespace App\Services;

use App\Repository\BookingRepository;

class BookingManager
{
    public function __construct(private BookingRepository $bookingRepository){
    }

    public function canBook(string $inputDate,int $truckId):bool
    {
        $bookingDate = \DateTime::createFromFormat('d-m-Y', $inputDate);
        $bookingDate->setTime(0,0,0);

        if(!$this->isDateBookable($bookingDate)){
            throw new \Exception('Booking not possible');
            return false;
        }

        if($this->hasBookThisWeek($bookingDate,$truckId)){
            throw new \Exception('Booking not possible');
            return false;
        }

        $nbTrucks = $this->getTrucksNumber($bookingDate);
        $remainingSpace = $this->getAvailableSpaces($bookingDate) - $nbTrucks;

        if($remainingSpace <= 0){
            throw new \Exception('Booking not possible');
            return false;
        }

        return true;
    }

    private function getTrucksNumber(\DateTime $bookingDate):int
    {
       $bookings = $this->bookingRepository->findBy(['bookingDate' => $bookingDate]);
       return count($bookings);
    }

    private function getAvailableSpaces(\DateTime $bookingDate):int
    {
        return ('5' === $bookingDate->format('w')) ? 6 : 7;
    }

    private function isDateBookable(\DateTime $bookingDate):bool
    {
        $today = new \DateTime('today');
        $diff = $today->diff( $bookingDate );
        $diffDays = (integer)$diff->format( "%R%a" );
        return !($diffDays <= 0);
    }

    private function hasBookThisWeek(\DateTime $bookingDate,int $truckId):bool
    {
        $bookings = $this->bookingRepository->findBookingPerWeekAndTruck($bookingDate,$truckId);
        return count($bookings) > 0;
    }
}