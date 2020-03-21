<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Version extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version {release=dev}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets config values for version.hash and optionally version.release';

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
        $release = $this->argument('release');
        $hash = trim(shell_exec('git rev-parse HEAD'));
        $content = "<?php

return [
    'hash' => '{$hash}',
    'release' => '{$release}'
];";

        $path = app_path() . '/../config/version.php';
        file_put_contents($path, $content);
    }
}
