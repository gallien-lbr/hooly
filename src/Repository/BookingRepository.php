<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBookingPerWeekAndTruck(\DateTime $bookingDate, int $truckId)
    {
        $w = intval($bookingDate->format('W'));
        $y = intval($bookingDate->format('Y'));

        $sql =  'SELECT count(*) FROM booking WHERE truck_id = ? 
                 and WEEK(booking_date) = ? AND YEAR(booking_date) = ? ';

        $query = $this->getEntityManager()->createNativeQuery($sql);
        $query->setParameter(1,$truckId);
        $query->setParameter(2,$w);
        $query->setParameter(3,$y);

        return $query->getResult();
    }
}
