<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class DbCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new postgres database with the name found in the pgsql config';

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
        $name = config('database.connections.pgsql.database');
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port');
        $user = config('database.connections.pgsql.username');
        $pass = config('database.connections.pgsql.password');

        $db = new PDO("pgsql:host=$host;port=$port", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        try {
            $db->exec('CREATE DATABASE "' . $name . '"');
            $this->getOutput()->writeln("<info>Successfully created database $name</info>");
        } catch (\Exception $e) {
            $this->getOutput()->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }
}
