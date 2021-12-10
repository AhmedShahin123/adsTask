<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;
use Carbon\carbon;

class DailyRemainderAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad:remainder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send a daily email at 08:00 PM that will be sent to advertisers who have ads the next day as a remainder.';

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
     * @return int
     */
    public function handle()
    {
        $ads = Ad::all();
        $currentDay = Carbon::now()->format('d-m-Y'); // current day

        foreach ($ads as $key => $ad) {
          // code...
          $AdDay = Carbon::parse($ad->start_date)->subDays(1)->format('d-m-Y');  // the preivous day of ad start date
          if($currentDay == $AdDay){                    //check if current day is same day of the preivous day of ad start date
            $ad->advertiser->sendRemainderAd($ad);     // send email remainder for advertiser
          }
        }

    }
}
