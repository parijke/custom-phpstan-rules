<?php

declare(strict_types=1);

namespace Rules\Architecture\data;

class IllegalExceptionUsed
{
    /**
     * @throws \Exception
     */
    public function index()
    {
            throw new \Exception('Hello World');
    }
}
