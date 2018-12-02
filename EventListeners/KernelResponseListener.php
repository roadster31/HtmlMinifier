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
 * Date: 02/12/2018 10:00
 */

namespace HtmlMinifier\EventListeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use voku\helper\HtmlMin;

require __DIR__ ."/../vendor/autoload.php";

class KernelResponseListener implements EventSubscriberInterface
{
    public function minifyOutput(FilterResponseEvent $event)
    {
        if ($event->getRequest()->getRequestFormat() === 'html') {
            $htmlMin = new HtmlMin();

            // Minify HTML content
            $event->getResponse()->setContent(
                $htmlMin->minify($event->getResponse()->getContent())
            );
        }
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['minifyOutput', 10]
        ];
    }
}
