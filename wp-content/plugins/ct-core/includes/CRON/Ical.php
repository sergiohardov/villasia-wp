<?php

namespace CTCore\CRON;

use CTCore\MVC\Controller\Ical as ControllerIcal;
use CTCore\MVC\Model\Villa;
use WP_Query;

class Ical
{
    const HOOK_NAME = 'ctcore_cron_ical_update';

    private $controller;

    function __construct()
    {
        $this->controller = new ControllerIcal();

        add_action(self::HOOK_NAME, [$this, 'cron_job']);
    }

    public static function cron_activate()
    {
        wp_clear_scheduled_hook(self::HOOK_NAME);
        wp_schedule_event(time(), 'hourly', self::HOOK_NAME);
    }

    public static function cron_deactivate()
    {
        wp_clear_scheduled_hook(self::HOOK_NAME);
    }

    public function cron_job()
    {
        $this->log('CRON start.');

        $data = $this->get_villas_ical_links();

        if ($data) {
            foreach ($data as $key => $item) {
                $this->set_villa_dates($key + 1, count($data), $item['id'], $item['link']);
            }
        }

        $this->log('CRON end.');

        return null;
    }

    private function get_villas_ical_links()
    {
        $this->log('Get villas data...');
        $result = [];

        $query = new WP_Query([
            'post_type'         => CTCORE_POST_TYPE_VILLA,
            'posts_per_page'    => -1,
            'meta_query'        => [
                [
                    'key'     => CTCORE_FIELD_VILLA_ICAL,
                    'value'   => '',
                    'compare' => '!=',
                ]
            ],
        ]);

        if ($query->have_posts()) {
            $this->log('Villas data recived.');

            while ($query->have_posts()) {
                $query->the_post();

                $result[] = [
                    'id' => get_the_ID(),
                    'link' => Villa::get_ical_link(get_the_ID())
                ];
            }
            wp_reset_postdata();
        } else {
            $this->log('Villas data empty.');
        }

        return $result;
    }

    private function set_villa_dates($step, $count, $id, $link)
    {
        $this->log(sprintf("[%s/%s] Job for villa id - %s...", $step, $count, $id));

        $req = $this->controller->update_dates($id, $link);

        $this->log($req ? 'Updated.' : 'No update.');

        return null;
    }

    private function log($data)
    {
        $file_path = CTCORE_LOGS_PATH . "cron_ical.log";

        if (file_exists($file_path)) {
            $fileTime = filectime($file_path);
            $currentTime = time();

            if ($currentTime - $fileTime >= 86400) unlink($file_path);
        }

        $timestamp = date("Y-m-d H:i:s");
        $log = "[$timestamp] - " . print_r($data, true) . "\n";
        error_log($log, 3, $file_path);
        return null;
    }
}
