<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace HtmlMinifier;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Model\ConfigQuery;
use Thelia\Module\BaseModule;

class HtmlMinifier extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'htmlminifier';

    public function postActivation(ConnectionInterface $con = null)
    {
        // The base HTML minifier should be disabled
        $currentHtmlOptimizerValue = ConfigQuery::read('html_output_trim_level', 1);

        ConfigQuery::write('html_output_trim_level_backup', $currentHtmlOptimizerValue, 1, 1);

        ConfigQuery::write('html_output_trim_level', 0);
    }

    public function postDeactivation(ConnectionInterface $con = null)
    {
        // Restore the base Minifier value
        $savedValue = ConfigQuery::write('html_output_trim_level_backup', 1);

        ConfigQuery::write('html_output_trim_level', $savedValue);
    }
}
