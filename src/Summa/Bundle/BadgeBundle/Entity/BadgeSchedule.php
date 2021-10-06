<?php

namespace Summa\Bundle\BadgeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\CronBundle\Entity\ScheduleIntervalInterface;
use Oro\Bundle\CronBundle\Entity\ScheduleIntervalTrait;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\AttachmentBundle\Entity\File;
use Summa\Bundle\BadgeBundle\Model\ExtendBadge;

/**
 * @ORM\Table(name="summa_badge_schedule")
 * @ORM\Entity(repositoryClass="Summa\Bundle\BadgeBundle\Entity\Repository\BadgeScheduleRepository")
 */
class BadgeSchedule implements ScheduleIntervalInterface
{
    use ScheduleIntervalTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Badge
     *
     * @ORM\ManyToOne(targetEntity="Summa\Bundle\BadgeBundle\Entity\Badge", inversedBy="schedules")
     * @ORM\JoinColumn(name="badge_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $badge;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="active_at", type="datetime", nullable=true)
     */
    protected $activeAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="deactivate_at", type="datetime", nullable=true)
     */
    protected $deactivateAt;

    /**
     * @param \DateTime|null $activeAt
     * @param \DateTime|null $deactivateAt
     */
    public function __construct(\DateTime $activeAt = null, \DateTime $deactivateAt = null)
    {
        $this->activeAt     = $activeAt;
        $this->deactivateAt = $deactivateAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Badge
     */
    public function getBadge(): Badge
    {
        return $this->badge;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduleIntervalsHolder()
    {
        return $this->getBadge();
    }

    /**
     * @param Badge $badge
     * @return $this
     */
    public function setBadge(Badge $badge)
    {
        $this->badge = $badge;
        $this->badge->setContainSchedule(true);

        return $this;
    }

    //Todo: ver esto
//    /**
//     * @param PriceListSchedule $compared
//     * @return bool
//     */
//    public function equals(PriceListSchedule $compared)
//    {
//        return $compared->getPriceList() === $this->getPriceList()
//            && $compared->getActiveAt() == $this->getActiveAt()
//            && $compared->getDeactivateAt() == $this->getDeactivateAt();
//    }
//
//    /**
//     * @return string
//     */
//    public function getHash()
//    {
//        return md5(json_encode([
//            'priceList' => $this->priceList ? spl_object_hash($this->priceList) : null,
//            'activeAt' => $this->activeAt,
//            'deactivateAt' => $this->deactivateAt
//        ]));
//    }
}