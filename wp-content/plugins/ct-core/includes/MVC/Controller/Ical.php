<?php

namespace CTCore\MVC\Controller;

use ICal\ICal as ICalParser;
use CTCore\MVC\Model\Ical as IcalModel;;

use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

class Ical
{
    private $model;

    function __construct()
    {
        $this->model = new IcalModel();
    }
    public function get_ical_data($url)
    {
        try {

            $headers = @get_headers($url);

            // TODO: add check on content type header
            if ($headers && strpos($headers[0], '200') === false) {
                throw new Exception('Error url: ' . $url);
            }

            $ical = new ICalParser('ICal.ics', array(
                'defaultSpan'                 => 2,     // Default value
                'defaultTimeZone'             => 'UTC',
                'defaultWeekStart'            => 'MO',  // Default value
                'disableCharacterReplacement' => false, // Default value
                'filterDaysAfter'             => null,  // Default value
                'filterDaysBefore'            => null,  // Default value
                'httpUserAgent'               => null,  // Default value
                'skipRecurrence'              => false, // Default value
            ));

            $result = $ical->initUrl($url, $username = null, $password = null, $userAgent = null);
        } catch (Exception $e) {
            $result = null;
        }

        return $result;
    }
    public function get_ical_dates($url)
    {
        $result = [];
        $ical_data = $this->get_ical_data($url);
        $events = $ical_data ? $ical_data->events() : null;

        if ($events) {
            foreach ($events as $event) {
                $date_start = $event->dtstart ? new DateTime($event->dtstart) : null;
                $date_end = $event->dtend ? new DateTime($event->dtend) : null;

                if ($date_start && $date_end) {
                    $period = new DatePeriod($date_start, DateInterval::createFromDateString('1 day'), $date_end);
                    foreach ($period as $day) {
                        $result[] = $day->format('Y-m-d');
                    }
                }
            }
        }

        return $result;
    }
    public function update_dates($post_id, $link)
    {
        if (!get_post($post_id) || empty($link)) return false;
        // TODO: big index in database

        $this->model->remove_dates($post_id);

        $dates = $this->get_ical_dates($link);

        if ($dates) {
            $this->model->set_dates($post_id, $dates);
            return true;
        }

        return false;
    }
}
