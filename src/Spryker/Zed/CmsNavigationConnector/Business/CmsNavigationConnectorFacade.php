<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsNavigationConnector\Business;

use Generated\Shared\Transfer\CmsPageTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\CmsNavigationConnector\Business\CmsNavigationConnectorBusinessFactory getFactory()
 */
class CmsNavigationConnectorFacade extends AbstractFacade implements CmsNavigationConnectorFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CmsPageTransfer $cmsPageTransfer
     *
     * @return void
     */
    public function updateCmsPageNavigationNodesIsActive(CmsPageTransfer $cmsPageTransfer)
    {
        $this->getFactory()
            ->createNavigationNodesIsActiveUpdater()
            ->updateCmsPageNavigationNodes($cmsPageTransfer->getFkPage(), (bool)$cmsPageTransfer->getIsActive());
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CmsPageTransfer $cmsPageTransfer
     *
     * @return void
     */
    public function deleteCmsPageNavigationNodes(CmsPageTransfer $cmsPageTransfer): void
    {
        $this->getFactory()
            ->createNavigationNodesWriter()
            ->deleteNavigationNodesByIdCmsPage($cmsPageTransfer->getFkPage());
    }
}
