<?php

namespace App\Repositories\Common;

interface ICommonRepository {
    public function fetch_gststate_list();
    public function fetch_country_list();
    public function get_states_by_country($countryid);
    public function get_city_by_state($stateid );
    public function get_town_by_district($districtid );

    public function get_postalcode_by_city($cityid );
    public function get_class_list($where);
    public function get_channel_list();
    public function get_subchannel_by_channel($where );
    public function get_group_list($where);

    

}
?>