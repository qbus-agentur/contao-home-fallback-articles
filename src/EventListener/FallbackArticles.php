<?php

/**
 * Contao Open Source CMS
 *
 * Home Fallback Articles Extension by Qbus
 *
 * @author  Alex Wuttke <alw@qbus.de>
 * @license LGPL-3.0+
 */

namespace Qbus\HomeFallbackArticles\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\PageModel;
use Contao\ArticleModel;
use Contao\Controller;

/*
 * Provide methods that get called in
 * Qbus\FallbackArticles\Hooks\GeneratePage::getFallbackArticles
 */
class FallbackArticles
{
    private $framework;

    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    // TODO: Return null instead of false, but that also requires adapting other
    //       extensions
    public function onGetFallbackArticles(int $pageId, string $section)
    {
        global $objPage;
        $pageModelAdapter = $this->framework->getAdapter(PageModel::class);
        $articleModelAdapter = $this->framework->getAdapter(ArticleModel::class);

        $homePage = $pageModelAdapter->findFirstPublishedByPid($objPage->rootId);

        if ($homePage === null) {
            return false;
        }

        $articleCollection = $articleModelAdapter->findPublishedByPidAndColumn($homePage->id, $section);

        if ($articleCollection === null) {
            return false;
        }

        $compiledSection = '';
        while ($articleCollection->next()) {
            $compiledSection .= Controller::getArticle($articleCollection->current(), false, false, $section);
        }

        return $compiledSection;
    }
}
