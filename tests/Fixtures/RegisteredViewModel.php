<?php
namespace Demander\Container\Test\Fixtures;

use Demander\ViewModel\AbstractViewModel;


final class RegisteredViewModel extends AbstractViewModel
{
    private $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function test()
    {
        return $this->test;
    }
}
