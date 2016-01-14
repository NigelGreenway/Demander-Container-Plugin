<?php
/**
 * This file is part of the Demander-Container-Plugin project
 *
 * Unauthorised copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 *
 * @copyright Copyright (c) 2016
 */
namespace Demander\Container\Test;

use Demander\CommandMediatorInterface;
use Demander\Container\ContainerMediator;
use Demander\Container\Test\Fixtures\NonRegisteredCommand;
use Demander\Container\Test\Fixtures\NonRegisteredQuery;
use Demander\Container\Test\Fixtures\RegisteredCommand;
use Demander\Container\Test\Fixtures\RegisteredCommandHandler;
use Demander\Container\Test\Fixtures\RegisteredQuery;
use Demander\Container\Test\Fixtures\RegisteredQueryHandler;
use Demander\Container\Test\Fixtures\RegisteredViewModel;
use Demander\Exception\CommandNotFoundException;
use Demander\Exception\QueryNotFoundException;
use Demander\QueryMediatorInterface;
use League\Container\Container;
use PHPUnit_Framework_TestCase;

class ContainerMediatorTest extends PHPUnit_Framework_TestCase
{
    /** @var ContainerMediator */
    private static $mediator;

    public static function setUpBeforeClass()
    {
        $container = new Container(null, null, null);
        $container->add(
            RegisteredQueryHandler::class,
            RegisteredQueryHandler::class
        )->withArgument('query.test');
        $container->add(
            RegisteredCommandHandler::class,
            RegisteredCommandHandler::class
        )->withArgument('command.test');

        static::$mediator = new ContainerMediator(
            $container,
            [
                RegisteredQuery::class => RegisteredQueryHandler::class,
            ],
            [
                RegisteredCommand::class => RegisteredCommandHandler::class,
            ]
        );
    }

    public function test_it_is_implements_of_QueryMediatorInterface()
    {
        $this->assertInstanceOf(QueryMediatorInterface::class, static::$mediator);
    }

    /**
     * @cover Demander\ContainerMediator::query
     */
    public function test_request_throws_QueryNotFoundException()
    {
        $this->setExpectedException(QueryNotFoundException::class);
        static::$mediator->request(new NonRegisteredQuery());
    }

    /**
     * @cover Demander\ContainerMediator::query
     * @cover Demander\ContainerMediator::addQueryHandlers
     */
    public function test_request_returns_a_RegisteredQuery()
    {
        $viewModel = static::$mediator->request(new RegisteredQuery());
        $this->assertInstanceOf(
            RegisteredViewModel::class,
            $viewModel
        );
        $this->assertEquals(
            'query.test',
            $viewModel->test()
        );
    }

    public function test_ContainerMediator_is_implements_of_CommandMediatorInterface()
    {
        $this->assertInstanceOf(CommandMediatorInterface::class, static::$mediator);
    }

    /**
     * @cover Demander\ContainerMediator::execute
     */
    public function test_request_throws_CommandNotFoundException()
    {
        $this->setExpectedException(CommandNotFoundException::class);
        static::$mediator->execute(new NonRegisteredCommand());
    }

    /**
     * @cover Demander\ContainerMediator::execute
     * @cover Demander\ContainerMediator::addCommandHandlers
     */
    public function test_RegisteredCommand_is_executed()
    {
        $this->assertEquals(
            'command.test',
            static::$mediator->execute(new RegisteredCommand())
        );
    }
}
