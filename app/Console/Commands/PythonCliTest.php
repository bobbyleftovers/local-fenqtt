<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonCLITest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lb:testPython';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run up a strip test with some demo data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo '-------------------------------------' . PHP_EOL;
        echo 'If all goes well we should see some text printed to the console once python runs.' . PHP_EOL;

        $json = json_encode([
            "userId" => 1,
            "id" => 1,
            "title" => "delectus aut autem",
            "completed" => false
        ]);
        $process = new Process("python3 /Users/robertrae/Sites/Enjoy/local-fenqtt/app/Console/Commands/pytest.py");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            echo 'Oh shit!' . PHP_EOL;
            throw new ProcessFailedException($process);
        }


        dump($process->getOutput());
        echo 'Test finished.' . PHP_EOL;
        echo 'If you got some errors and need more info, run the command again with the -v option' . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
    }
}
