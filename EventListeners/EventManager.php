<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace OrderStatusHistory\EventListeners;

use OrderStatusHistory\Model\OrderStatusChange;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;

class EventManager implements EventSubscriberInterface
{
    /**
     * @param OrderEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function orderStatusChange(OrderEvent $event)
    {
        (new OrderStatusChange())
            ->setOrderId($event->getOrder()->getId())
            ->setOrderStatusId($event->getStatus())
            ->setChangeDate(new \DateTime())
            ->save()
        ;
    }
    /**
     * @param OrderEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function orderCreated(OrderEvent $event)
    {
        (new OrderStatusChange())
            ->setOrderId($event->getOrder()->getId())
            ->setOrderStatusId(OrderStatusQuery::getNotPaidStatus()->getId())
            ->setChangeDate(new \DateTime())
            ->save()
        ;
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::ORDER_UPDATE_STATUS  => ['orderStatusChange', 10 ],
            TheliaEvents::ORDER_AFTER_CREATE   => ['orderCreated', 10 ]
        ];
    }
}
