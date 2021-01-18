<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewsletter;
use Illuminate\Support\Facades\Log;

use App\Models\Newsletter;

use App\Models\User;
use App\Models\OrganizationUser;
use App\Models\OrganizationSubscription;
use App\Models\Language;
use App\Models\City;

class DeployNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $newsletter;
    public $receivers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;

        $this->receivers = $this->receiversCollection();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->receivers as $collection) {
            foreach ($collection as $collector) {
                foreach ($collector as $receiver) {

                    if (!isset($receiver->email)) {
                        $receiver = User::findOrFail($receiver->user_id);
                    }  
                    Mail::to($receiver)
                        ->send(new SendNewsletter($this->newsletter));
                }
            }
        }
    }

    /*
     * Calculate the receivers
    */
    public function receiversCollection()
    {
        // Collect the targets
        $targets = explode('<br>', $this->newsletter->target);

        // Determine the target indexes
        $target_indexes = count($targets);

        /* 
         * Know which targets were selected
         *
         * subscribers only (target_indexes) = 3
         * members only (target_indexes) = 5
         * members + subscribers (target_indexes) = 7
        */
        $collector = [];

        if ($target_indexes == 3) {
            array_push($collector, $this->collectSubscribers($targets, $this->newsletter));
        } 
        
        if ($target_indexes == 5) {
            array_push($collector, $this->collectMembers($targets, $this->newsletter));
        }

        if ($target_indexes == 7) {
            array_push($collector, $this->collectSubscribers($targets, $this->newsletter));
            array_push($collector, $this->collectMembers($targets, $this->newsletter));
        }

        return $collector;
    }

    public function collectMembers($targets, $newsletter)
    {
        // Collector
        $collector = [];

        // Algorithm
        $languages = explode(':', $targets[1]);
        $languages_selector = trim($languages[1]);

        $cities = explode(':', $targets[2]);
        $cities_selector = trim($cities[1]);

        // If languages is all
        if ($languages_selector == 'All') {

            // If city is all
            if ($cities_selector == 'All') {
                array_push($collector, OrganizationUser::where('organization_id', $newsletter->organization_id)->get());
            } 

            // user wants specific cities
            else {
                $cities = explode(',', $cities_selector);

                foreach ($cities as $city) {
                    if (!empty($city)) {
                        array_push($collector, City::where('name', trim($city))->first()->users()->where('users.organization_id', $newsletter->organization_id)->get());
                    }
                }
            }
        } 

        // specific languages
        else {
            // If city is all
            if ($cities_selector == 'All') {
                array_push($collector, Language::where('name', $languages_selector)->first()->organizationUsers()->where('users.organization_id', $newsletter->organization_id)->get());
            } 

            // user wants specific cities
            else {
                $cities = explode(',', $cities_selector);

                foreach ($cities as $city) {
                    if (!empty($city)) {
                        array_push($collector, City::where('name', trim($city))->first()->users()->where('users.organization_id', $newsletter->organization_id)->where('users.language_id', Language::where('name', $languages_selector)->first()->id)->get());
                    }
                }
            }
        }

        return $collector;
    }

    public function collectSubscribers($targets, $newsletter)
    {
        // Collector
        $collector = [];

        // Algorithm
        $languages = explode(':', $targets[1]);

        $languages_selector = trim($languages[1]);

        if ($languages_selector == 'All') {
            array_push($collector, OrganizationSubscription::where('organization_id', $newsletter->organization_id)->get());
        } else {
            array_push($collector, Language::where('name', $languages_selector)->first()->subscribers()->where('organization_id', $newsletter->organization_id)->get());
        }

        return $collector;
    }
}
