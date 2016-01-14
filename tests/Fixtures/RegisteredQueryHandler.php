<?php
namespace Demander\Container\Test\Fixtures;

use Demander\AbstractViewModel;
use Demander\QueryHandlerInterface;
use Demander\QueryInterface;


final class RegisteredQueryHandler implements QueryHandlerInterface
{
    private $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function handle(QueryInterface $query)
    {
        return new RegisteredViewModel($this->test);
    }
}
