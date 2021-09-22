<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\VicoReferral;
use App\Jobs\GenerateReferralCode;
use App\Jobs\GenerateReferralCodeNoQueue;

class referralsforeveryone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referralsallarround';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $users = User::all();
        foreach ($users as $user) {
            $referral = VicoReferral::where('user_id',$user->id)->first();
            if (is_null($referral)) {
                dispatch(new GenerateReferralCodeNoQueue($user));
            }
        }
    }
}
