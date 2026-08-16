<?php

namespace App\Console\Commands;

use App\Services\ApiTester;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('apis:test')]
#[Description('Command description')]
class TestApisCommand extends Command
{
    /**
     * Execute the console command.
     */

    // public function __construct(protected ApiTester $apiTester){}
    public function handle(ApiTester $apiTester)
    {
        $res = $apiTester->testAll();
        $this->line(json_encode($res,JSON_PRETTY_PRINT));
    }
}
