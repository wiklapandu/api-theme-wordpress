<?php
/**
* Use for Log
* Author: Wikla
*
*
* @package HelloElementor
*/
namespace MI\Helper;

defined( 'ABSPATH' ) || die( "Can't access directly" );


class Log
{
    /**
     * @var string $log_path
     * 
     * * the place of where we will save the log
     * * The destination. Its meaning depends on the error_message_type parameter as described above.
    */
    protected static $log_path = WP_CONTENT_DIR . '/logs';
    /**
     * @var int $permission_code
     * * [optional] The mode is 0777 by default, which means the widest possible access. 
     * * For more information on modes, read the details on the chmod page.
    */
    protected static $permission_code = 0777;
    /**
     * @var int $error_message_type
     * ? Says where the error should go. The possible message types are as follows: error_log() log types 
     * * | 0 | message is sent to PHP's system logger, using the Operating System's system logging mechanism or a file, depending on what the error_log configuration directive is set to. This is the default option. | 
     * * | 1 | message is sent by email to the address in the destination parameter. This is the only message type where the fourth parameter, additional_headers is used. | 
     * * | 2 | No longer an option. | 
     * * | 3 | message is appended to the file destination. A newline is not automatically added to the end of the message string. | 
     * * | 4 | message is sent directly to the SAPI logging handler. |
    */ 
    protected static $error_message_type = 3;
    protected static $flag_json = JSON_PRETTY_PRINT;
        
    /**
     * error
     * 
     * to record log for type error
     * this function have purpose to reduce the use of wordpress' default error_log
     *
     * @param  string $message
     * @param  array $data
     * @param  string $fileName by default we save the log into debug.log file
     * @return void
     */
    public static function error(string $message,array $data = null,string $fileName = 'debug'): void
    {
        self::print('error', $message, $data, $fileName);
    }
    /**
     * info
     * 
     * to record log for type info
     * this function have purpose to reduce the use of wordpress' default error_log
     *
     * @param  string $message
     * @param  array $data
     * @param  string $fileName by default we save the log into debug.log file
     * @return void
     */
    public static function info($message, $data = null, $fileName = 'debug', $pretty = true): void
    {
        self::print('info', $message, $data, $fileName, $pretty);
    }
    
    /**
     * warning
     * 
     * to record log for type warning
     * this function have purpose to reduce the use of wordpress' default error_log
     *
     * @param  string $message
     * @param  array $data
     * @param  string $fileName by default we save the log into debug.log file
     * @return void
     */
    public static function warning($message, $data = null, $fileName = 'debug'): void
    {
        self::print('warning', $message, $data, $fileName);
    }

    private static function print($type = 'info', $message = '', $data = null, $fileName = 'debug', $pretty = true): void
    {

        $explode = explode('/', $fileName) ?? $fileName;
        $fileName = is_array($explode) ? end($explode) : $explode;

        if (is_array($explode)) {
            unset($explode[count($explode) - 1]);
        }
        $custom_path = is_array($explode) ? implode('/', $explode) : '';

        $current_time = current_time('mysql');
        if($data !== null) {
            $flags = $pretty ? self::$flag_json : 0;
            $message .= ": " . json_encode($data, $flags);
        }

        $log_message = sprintf("[%s][%s] %s \n", $current_time, $type, $message);
        $filePath = self::$log_path;
        if($custom_path) {
            $filePath .= "/$custom_path";
        }

        if (!file_exists($filePath)) mkdir($filePath, self::$permission_code, true);
        error_log($log_message, self::$error_message_type, $filePath."/".$fileName.'.log');
    }
}