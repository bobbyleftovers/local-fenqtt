<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


class ConnectCliTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lb:testConnection {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests the API connection to bobby.af and grabs some demo data for a quick python test';

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
        $id = $this->argument('id');
        echo 'Calling ' . 'http://bobby.af/api/get-json/' . $id . PHP_EOL;

        // Run a cURL request to get data from bobby.af
        $response = Curl::to('http://bobby.af/api/get-json/' . $id)
            ->get();
        $response = json_decode($response);
        // Bail if there's an error
        if (property_exists($response, 'error')) {
            echo $response->error . PHP_EOL;
            echo 'Try again' . PHP_EOL;
            echo '-------------------------------------' . PHP_EOL;
            return false;
        }

        // OK
        echo 'Resource found!' . PHP_EOL;
        // var_dump($_SERVER);
        // Run a python script with the JSON returned in the request
        echo 'Running python script....' . PHP_EOL;
        $file_path = 'json/' . $response->filename . '.json';
        Storage::disk('public')->put($file_path, $response->image_json);
        // Storage::disk('public')->putFileAs('json', new File($file_path), $response->filename . '.json');
        $file_url = asset($file_path);
        $tsturl = 'public/json/' . $response->filename . '.json';
        $process = new Process("python3 /Users/robertrae/Sites/Enjoy/local-fenqtt/app/Console/Commands/test.py {$tsturl}");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            echo 'Oh shit!' . PHP_EOL;
            throw new ProcessFailedException($process);
        }

        dump($process->getOutput());

        echo 'Test finished.' . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
    }
}
