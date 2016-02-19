<?php
/**
 * This file is part of the Demander-Container-Plugin project
 *
 * Unauthorised copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 *
 * @copyright Copyright (c) 2016
 */
namespace Demander\Container;

use Demander\CommandInterface;
use Demander\CommandMediatorInterface;
use Demander\Exception\CommandNotFoundException;
use Demander\Exception\QueryNotFoundException;
use Demander\QueryInterface;
use Demander\QueryMediatorInterface;
use Demander\ViewModel;
use League\Container\Container;

/**
 * A mediator that resolves Queries and Commands via Container
 *
 * @author Nigel Greenway <github@futurepixels.co.uk>
 * @final
 */
class ContainerMediator implements QueryMediatorInterface, CommandMediatorInterface
{
    /** @var Container */
    private $container;
    /** @var array */
    private $queryNameToHandlerMap   = [];
    /** @var array */
    private $commandNameToHandlerMap = [];

    /**
     * Constructor
     *
     * @param Container $container
     * @param array     $queryMapping
     * @param array     $commandMapping
     */
    public function __construct(
        Container $container,
        array     $queryMapping,
        array     $commandMapping
    ) {
        $this->container = $container;
        $this->addQueryHandlers($queryMapping);
        $this->addCommandHandlers($commandMapping);
    }

    /** @inheritDoc */
    public function request(QueryInterface $query)
    {
        $className = get_class($query);

        if (array_key_exists($className, $this->queryNameToHandlerMap) === false) {
            throw new QueryNotFoundException($className);
        }

        $handler = $this->container->get($this->queryNameToHandlerMap[$className]);

        return $handler->handle($query);
    }

    /** @inheritDoc */
    public function execute(CommandInterface $command)
    {
        $className = get_class($command);

        if (array_key_exists($className, $this->commandNameToHandlerMap) === false) {
            throw new CommandNotFoundException($className);
        }

        $handler = $this->container->get($this->commandNameToHandlerMap[$className]);

        return $handler->execute($command);
    }

    /**
     * @param array $queryNameToHandlerMap
     *
     * @return void
     */
    private function addQueryHandlers(array $queryNameToHandlerMap)
    {
        foreach ($queryNameToHandlerMap as $key => $value) {
            $this->queryNameToHandlerMap[$key] = $value;
        }
    }

    /**
     * @param array $commandNameToHandlerMap
     *
     * @return void
     */
    private function addCommandHandlers(array $commandNameToHandlerMap)
    {
        foreach ($commandNameToHandlerMap as $key => $value) {
            $this->commandNameToHandlerMap[$key] = $value;
        }
    }
}
