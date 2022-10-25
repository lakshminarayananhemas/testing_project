<?php 

namespace App\Repositories\Configuration;

use App\Models\altec_jc_calendar;


class ConfigurationRepository implements IConfigurationRepository
{
    public function get_jc_calender($data){
        $altec_jc_calendar = altec_jc_calendar::all();
        return $altec_jc_calendar;
    }

}