<?php
/**
 * ownCloud - bav
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Claus-Justus Heine <himself@claus-justus-heine.de>
 * @copyright Claus-Justus Heine 2014
 */

namespace OCA\BAV\AppInfo;

\OC::$CLASSPATH['IBAN'] = 'bav/3rdparty/php-iban/oophp-iban.php';
\OC::$CLASSPATH['malkusch\bav\BAV'] = 'bav/3rdparty/bav/autoloader/autoloader.php';

\OCP\Util::addScript('bav', 'script');
\OCP\Util::addStyle('bav', 'style');

\OCP\App::addNavigationEntry(array(
    // the string under which your app will be referenced in owncloud
    'id' => 'bav',

    // sorting weight for the navigation. The higher the number, the higher
    // will it be listed in the navigation
    'order' => 10,

    // the route that will be shown on startup
    'href' => \OCP\Util::linkToRoute('bav.page.index'),

    // the icon that will be shown in the navigation
    // this file needs to exist in img/
    'icon' => \OCP\Util::imagePath('bav', 'bav.svg'),

    // the title of your application. This will be used in the
    // navigation or on the settings page of your app
    'name' => \OC_L10N::get('bav')->t('BAV')
));
