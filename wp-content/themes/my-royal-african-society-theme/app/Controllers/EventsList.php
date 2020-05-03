<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class EventsList extends Controller
{
    
    public static function getAllEvents() {

        $events_ticket_price = get_field('events_ticket_price');

        return $events_ticket_price;

    }
}