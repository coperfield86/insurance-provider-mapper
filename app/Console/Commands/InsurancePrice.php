<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InsurancePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insurance-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $choices = [
            1 => 'sendgrid - test a template manually (SendgridController)',
            2 => 'sendgrid - test full Job send template (SendMailTemplateJob, queue)',
            3 => 'Exchangerate - test manual exchange conversion (ExchangerateController)',
            4 => 'test googleMaps api',
            5 => 'Mailtrap Examples',
        ];

        $choice = $this->choice('What do you want to do?', $choices, 35);
        $key    = array_search($choice, $choices);
    }
}
