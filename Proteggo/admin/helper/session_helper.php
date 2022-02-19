<?php
    class SessionHelper{
        // ctor
        public function __construct()
        {
            // check if the session is already started
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }
        }

        public function make_session_variable($key, $value){
            $_SESSION[$key] = $value;
        }

        // check if the specific session is set
        public function is_session_exists($key){
            return isset($_SESSION[$key]);
        }

        public function get_session_value($key){
            return $_SESSION[$key];
        }

        // remove one session variable
        public function unset_session_variable($key){
            unset($_SESSION[$key]);
        }

        // remove all the sessions
        public function remove_all_session_variables(){
            session_unset();
        }

        // destroy the session
        public function destroy_session(){
            session_destroy();
        }
    }
?>