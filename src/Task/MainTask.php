<?php
declare (strict_types=1);

namespace Task;

class MainTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo 'Benchmark tasks' . PHP_EOL;
    }
}