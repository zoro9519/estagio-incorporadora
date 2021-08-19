<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ResponseHelper {

    protected static $instance = null;

    public function __invoke()
    {
        if(!self::$instance)
            self::$instance = new ResponseHelper;
    }
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, string $message = null, int $code = 200)
	{
        self::log($data, $message);
		return response()->json([
			'status' => 'success',
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
	public static function error(string $message = null, int $code, $data = [])
	{
        self::log($data, $message);
		return response()->json([
			'status' => 'error',
			'message' => $message,
			'data' => $data
		], $code);
	}

    public static function log($data, $title) {

        $today = date("Y-m-d");
        $now = date("H:i:s");

        $content = "";
        $content .= "--------------------------------------\r\n";
        $content .= $today . " - " . $now . ": ";
        $content .= $title . "\r\n";
        $content .= json_encode($data);
        $content .= "\r\n";
        $instance = self::$instance;    
        Storage::disk("local")->append($today . ".log", $content);
    }
}