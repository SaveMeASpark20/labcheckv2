<?php

class NotificationManager {
    private $notifications = [];

    public function __construct() {
        if (isset($_SESSION['notification'])) {
            $this->notifications[] = $_SESSION['notification'];
            unset($_SESSION['notification']);
        }
        else {
            $this->notifications[] = [
                'message' => '',
                'type' => ''
            ];
        }
    }

    public function getNotifications() {
        return $this->notifications;
    }
}

?>
