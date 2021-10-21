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

use Doctrine\Common\Collections\Criteria;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\OrderVersion;
use Thelia\Model\OrderVersionQuery;

/**
 * Class OrderStatusHistory
 * @package OrderStatusHistory\Loop
 * @method int getOrderId()
 */
class OrderStatusHistory extends BaseLoop implements ArraySearchLoopInterface
{
    public function buildArray()
    {
        $changes = OrderVersionQuery::create()
            ->filterById($this->getOrderId())
            ->orderByVersionCreatedAt(Criteria::ASC)
            ->find();

        $current = null;

        $result = [];

        /** @var OrderVersion $change */
        foreach ($changes as $change) {
            if ($change->getStatusId() === $current) {
                continue;
            }

            $current = $change->getStatusId();

            $result[] = [
                'ID' => $change->getId(),
                'ORDER_ID' => $change->getId(),
                'STATUS_ID' => $change->getStatusId(),
                'CHANGE_DATE' => $change->getVersionCreatedAt()
            ];
        }

        return $result;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var orderversion $item */
        foreach ($loopResult->getResultDataCollection() as $item) {
            $loopResultRow = new LoopResultRow($item);

            foreach ($item as $key => $value) {
                $loopResultRow->set($key, $value);
            }

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
