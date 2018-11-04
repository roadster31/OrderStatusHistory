<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace OrderStatusHistory\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class HookManager extends BaseHook
{
    public function onOrderEditCartBottom(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                "orderstatushistory/order-edit-cart-bottom.html",
                [ 'order_id' => $event->getArgument('order_id') ]
            )
        );
    }
}
