<?php

class ProxiBlue_McryptCronTest_Model_Cron
{
    /**
     * A simple crypt and encrypt
     *
     * This exists to test an issue that happens at magemojo hosting for cron runs
     * and usage of mcrypt on PHP7.2
     * @param $schedule
     * @return string
     */
    public static function run($schedule)
    {
        try {
            // test if method exists in this version of php
            if (!function_exists('phpseclib_mcrypt_list_algorithms')) {
                Mage::log('phpseclib_mcrypt_list_algorithms does not exist' );
            } else {
                Mage::log('phpseclib_mcrypt_list_algorithms EXISTS!' );
            }
            if(!file_exists('/tmp/phpinfo_cron')) {
                ob_start();
                phpinfo();
                $info = ob_get_contents();
                ob_end_clean();

                $fp = fopen('/tmp/phpinfo_cron', "w+");
                fwrite($fp, $info);
                fclose($fp);
            }

            $test = Mage::getModel('core/encryption')->encrypt('foo-bar');
            Mage::log('Encrypt test: ' . $test);
            $test = Mage::getModel('core/encryption')->decrypt($test);
            Mage::log('Decrypt test: ' . $test);

        } catch (Exception $e) {
            // save any errors.
            Mage::logException($e);
            return $e->getMessage();
        }
    }
}