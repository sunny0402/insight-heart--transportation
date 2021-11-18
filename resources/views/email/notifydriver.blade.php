Howdy {{$mailDataDriver['driver_name']}},
<p>An InsighHeartGo client has booked a ride with you.</p>
<p>Please review appointment details:<br>
    Time & Date: {{$mailDataDriver['time']}}, {{$mailDataDriver['date']}}<br>
    Pickup & Drop off Locations: {{$mailDataDriver['pick_up_location']}}, {{$mailDataDriver['drop_off_location']}}<br>
</p>

<p>
    Please contact client to confirm details.<br>
    Client Info:<br>
    Driver Name: {{$mailDataDriver['client_name']}}
    Driver Phone: {{$mailDataDriver['client_phone']}}
</p>

<p>
    Foundation Contact Info:
    InsighHeart Foundation
    (416) - 123 -4567
</p>
