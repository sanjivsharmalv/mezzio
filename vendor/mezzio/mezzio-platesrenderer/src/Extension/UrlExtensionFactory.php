<?php

declare(strict_types=1);

namespace Mezzio\Plates\Extension;

use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use Mezzio\Plates\Exception\MissingHelperException;
use Psr\Container\ContainerInterface;

use function sprintf;

/**
 * Factory for creating a UrlExtension instance.
 */
class UrlExtensionFactory
{
    /**
     * @throws MissingHelperException If UrlHelper service is missing.
     * @throws MissingHelperException If ServerUrlHelper service is missing.
     */
    public function __invoke(ContainerInterface $container): UrlExtension
    {
        if (
            ! $container->has(UrlHelper::class)
            && ! $container->has(UrlHelper::class)
        ) {
            throw new MissingHelperException(sprintf(
                '%s requires that the %s service be present; not found',
                UrlExtension::class,
                UrlHelper::class
            ));
        }

        if (
            ! $container->has(ServerUrlHelper::class)
            && ! $container->has(ServerUrlHelper::class)
        ) {
            throw new MissingHelperException(sprintf(
                '%s requires that the %s service be present; not found',
                UrlExtension::class,
                ServerUrlHelper::class
            ));
        }

        return new UrlExtension(
            $container->has(UrlHelper::class)
                ? $container->get(UrlHelper::class)
                : $container->get(UrlHelper::class),
            $container->has(ServerUrlHelper::class)
                ? $container->get(ServerUrlHelper::class)
                : $container->get(ServerUrlHelper::class)
        );
    }
}
