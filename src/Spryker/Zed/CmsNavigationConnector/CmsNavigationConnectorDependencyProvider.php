<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsNavigationConnector;

use Spryker\Zed\CmsNavigationConnector\Dependency\Facade\CmsNavigationConnectorToNavigationFacadeBridge;
use Spryker\Zed\CmsNavigationConnector\Dependency\QueryContainer\CmsNavigationConnectorToCmsQueryContainerBridge;
use Spryker\Zed\CmsNavigationConnector\Dependency\QueryContainer\CmsNavigationConnectorToNavigationQueryContainerBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\CmsNavigationConnector\CmsNavigationConnectorConfig getConfig()
 */
class CmsNavigationConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_NAVIGATION = 'FACADE_NAVIGATION';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_CMS = 'QUERY_CONTAINER_CMS';

    /**
     * @var string
     */
    public const QUERY_CONTAINER_NAVIGATION = 'QUERY_CONTAINER_NAVIGATION';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $this->addCmsQueryContainer($container);
        $this->addNavigationQueryContainer($container);
        $this->addNavigationFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addCmsQueryContainer(Container $container)
    {
        $container->set(static::QUERY_CONTAINER_CMS, function (Container $container) {
            return new CmsNavigationConnectorToCmsQueryContainerBridge($container->getLocator()->cms()->queryContainer());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addNavigationQueryContainer(Container $container)
    {
        $container->set(static::QUERY_CONTAINER_NAVIGATION, function (Container $container) {
            return new CmsNavigationConnectorToNavigationQueryContainerBridge($container->getLocator()->navigation()->queryContainer());
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addNavigationFacade(Container $container)
    {
        $container->set(static::FACADE_NAVIGATION, function (Container $container) {
            return new CmsNavigationConnectorToNavigationFacadeBridge($container->getLocator()->navigation()->facade());
        });
    }
}
