<?php
'namespace org\muge\oauth2login';

if (!class_exists('M0704aOauth2LoginActor')) {
    class M0704aOauth2LoginActor {


        public static function oauth2_login_parse_json($json_str) {
            $json = json_decode($json_str, TRUE);
            return $json;
        }

        /**
         * @param $json
         */
        public static function oauth2_login_json_values($json) {
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator($json),
                RecursiveIteratorIterator::SELF_FIRST);

            foreach ($jsonIterator as $key => $val) {
                if(is_array($val)) {
                    echo "$key:\n";
                } else {
                    echo "$key => $val\n";
                }
            }
        }
    }

}

$oauth_2_login = new M0704aOauth2LoginActor();



?>
