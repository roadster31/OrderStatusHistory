<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 */
namespace OrderStatusHistory\Loop;

use OrderStatusHistory\Model\OrderStatusChange;
use OrderStatusHistory\Model\OrderStatusChangeQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class OrderStatusHistory
 * @package OrderStatusHistory\Loop
 * @method int getOrderId()
 */
class OrderStatusHistory extends BaseLoop implements PropelSearchLoopInterface
{
    public function buildModelCriteria()
    {
        $search = OrderStatusChangeQuery::create()
            ->filterByOrderId($this->getOrderId())
            ->orderByChangeDate()
        ;

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var OrderStatusChange $item */
        foreach ($loopResult->getResultDataCollection() as $item) {
            $loopResultRow = new LoopResultRow($item);

            $loopResultRow
                ->set('ID', $item->getId())
                ->set('ORDER_ID', $item->getOrderId())
                ->set('ORDER_STATUS_ID', $item->getOrderStatusId())
                ->set('CHANGE_DATE', $item->getChangeDate())
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument("order_id", null, true)
        );
    }
}
