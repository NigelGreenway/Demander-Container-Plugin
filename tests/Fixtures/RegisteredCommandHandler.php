<?php
namespace Demander\Container\Test\Fixtures;

use Demander\CommandHandlerInterface;
use Demander\CommandInterface;

final class RegisteredCommandHandler implements CommandHandlerInterface
{
    private $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function execute(CommandInterface $command)
    {
        return $this->test;
    }
}
