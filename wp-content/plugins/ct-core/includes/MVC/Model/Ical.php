<?php

namespace CTCore\MVC\Model;

class Ical
{
    /**
     * Get booked days of villa
     *
     * @param int|string $post_id
     * @return array
     */
    // TODO: have error if database not created
    public static function get_dates($post_id)
    {
        if (!get_post($post_id)) return [];

        global $wpdb;

        $table_name = CTCORE_ICS_TABLE_NAME;
        $dates = $wpdb->get_col("SELECT date FROM $table_name WHERE id_villa = $post_id");

        return is_array($dates) ? $dates : [];
    }

    /**
     * Insert rows for booked date of villa
     *
     * @param int|string $post_id
     * @param array $dates
     * @return bool
     */
    public function set_dates($post_id, $dates)
    {
        if (!get_post($post_id) || !$dates) return false;

        global $wpdb;

        foreach ($dates as $date) {
            $wpdb->insert(
                CTCORE_ICS_TABLE_NAME,

                [
                    'id' => NULL,
                    'id_villa' => $post_id,
                    'date' => $date
                ],

                ['%d', '%s', '%s']
            );
        }

        return true;
    }

    /**
     * Delete booked date rows of villa
     *
     * @param int|string $post_id
     * @return int|false
     */
    public function remove_dates($post_id)
    {
        if (!get_post($post_id)) return false;

        global $wpdb;

        return $wpdb->delete(CTCORE_ICS_TABLE_NAME, ['id_villa' => $post_id]);
    }

    /**
     * Created database if not exist
     *
     * @return bool
     */
    public static function create_table()
    {
        global $wpdb;

        $table_name = CTCORE_ICS_TABLE_NAME;
        $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->esc_like($table_name)));

        if (!$table_exists) {
            $wpdb->query("CREATE TABLE $table_name (
                id INT NOT NULL AUTO_INCREMENT, 
                id_villa BIGINT(20) NOT NULL, 
                date DATE NOT NULL, 
                PRIMARY KEY (id)
            ) ENGINE = InnoDB");

            if (!$wpdb->last_error) return true;
        }

        return false;
    }
}
