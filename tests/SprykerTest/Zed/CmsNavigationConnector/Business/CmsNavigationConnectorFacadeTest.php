<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CmsNavigationConnector\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CmsPageAttributesTransfer;
use Generated\Shared\Transfer\CmsPageTransfer;
use Generated\Shared\Transfer\NavigationNodeLocalizedAttributesTransfer;
use Generated\Shared\Transfer\NavigationNodeTransfer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CmsNavigationConnector
 * @group Business
 * @group Facade
 * @group CmsNavigationConnectorFacadeTest
 * Add your own group annotations below this line
 */
class CmsNavigationConnectorFacadeTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\CmsNavigationConnector\CmsNavigationConnectorBusinessTester
     */
    protected $tester;

    public function testSetNavigationNodeToActiveWhenCmsIsActive(): void
    {
        $this->runUpNavigationNodeCmsTest(true);
    }

    public function testSetNavigationNodeToInactiveWhenCmsIsInactive(): void
    {
        $this->runUpNavigationNodeCmsTest(false);
    }

    public function testDeleteCmsPageNavigationNodesIsSuccessful(): void
    {
        // Arrange
        $cmsPageTransfer = $this->createCmsPage();
        $navigationNodes = $this->createNavigationNodesByCmsPage($cmsPageTransfer);

        // Act
        $this->tester->getFacade()->deleteCmsPageNavigationNodes($cmsPageTransfer);

        // Assert
        $navigationFacade = $this->tester->getNavigationFacade();
        foreach ($navigationNodes as $navigationNode) {
            $navigationNode = $navigationFacade->findNavigationNode($navigationNode);
            $this->assertNull($navigationNode);
        }
    }

    protected function runUpNavigationNodeCmsTest(bool $isActive): void
    {
        // Arrange
        $cmsPageTransfer = $this->createCmsPage($isActive);
        $navigationNodes = $this->createNavigationNodesByCmsPage($cmsPageTransfer);

        // Act
        $this->tester->getFacade()->updateCmsPageNavigationNodesIsActive($cmsPageTransfer);

        // Assert
        $navigationFacade = $this->tester->getLocator()->navigation()->facade();
        foreach ($navigationNodes as $navigationNode) {
            $navigationNode = $navigationFacade->findNavigationNode($navigationNode);
            $this->assertSame($isActive, $navigationNode->getIsActive());
        }
    }

    protected function createCmsPage(?bool $isActive = true): CmsPageTransfer
    {
        // Arrange
        $locale = $this->tester->haveLocale();

        return $this->tester->haveCmsPage([
            CmsPageTransfer::IS_ACTIVE => $isActive,
            CmsPageTransfer::FK_TEMPLATE => 1,
            CmsPageAttributesTransfer::FK_LOCALE => $locale->getIdLocale(),
            CmsPageAttributesTransfer::LOCALE_NAME => $locale->getLocaleName(),
        ]);
    }

    protected function createNavigationNodesByCmsPage(CmsPageTransfer $cmsPageTransfer): array
    {
        $navigation = $this->tester->haveNavigation();
        $locale = $this->tester->haveLocale();

        /** @var \Spryker\Zed\Url\Persistence\UrlQueryContainerInterface $urlQueryContainer */
        $urlQueryContainer = $this->tester->getLocator()->url()->queryContainer();
        $urls = $urlQueryContainer->queryUrls()->filterByFkResourcePage($cmsPageTransfer->getFkPage())->find();

        $navigationNodes = [];

        foreach ($urls as $url) {
            $navigationNodes[] = $this->tester->haveLocalizedNavigationNode([
                NavigationNodeTransfer::FK_NAVIGATION => $navigation->getIdNavigation(),
                NavigationNodeLocalizedAttributesTransfer::FK_URL => $url->getIdUrl(),
                NavigationNodeLocalizedAttributesTransfer::FK_LOCALE => $locale->getIdLocale(),
                NavigationNodeTransfer::IS_ACTIVE => !$cmsPageTransfer->getIsActive(),
            ]);
        }

        return $navigationNodes;
    }
}
