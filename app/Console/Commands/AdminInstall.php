<?php

namespace App\Console\Commands;

use App\User;
use App\Setting;
use Illuminate\Console\Command;

class AdminInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laravel admin panel.';

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
        $this->userInstallation();
        $this->settingsInstallation();

        return 'Installation complete.';
    }

    /**
     * Admin user installation.
     */
    protected function userInstallation(): void
    {
        $this->comment('Please enter information for an admin account.');

        $firstName = $this->ask('First name');
        $lastName = $this->ask('Last name');
        $username = $this->ask('Username');
        $password = $this->secret('Password');

        User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'password' => bcrypt($password),
        ]);

        $this->info('Admin account created.');
    }

    /**
     * Website settings installation.
     */
    protected function settingsInstallation(): void
    {
        $this->comment('Please enter information for website settings.');

        foreach (Setting::SETTINGS_LIST['general'] as $settingName => $settingLabel) {
            $value = $this->ask($settingLabel);

            Setting::updateOrCreate([
                'name' => $settingName
            ], [
                'value' => $value
            ]);
        }

        $this->info('Settings saved.');
    }
}
