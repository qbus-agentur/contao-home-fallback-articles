<?php

/**
 * Contao Open Source CMS
 *
 * Home Fallback Articles Extension by Qbus
 *
 * @author  Alex Wuttke <alw@qbus.de>
 * @license LGPL-3.0+
 */

$GLOBALS['TL_HOOKS']['getFallbackArticles']['home'] = [
    'home_fallback_articles.listener.fallback_articles',
    'onGetFallbackArticles'
];
