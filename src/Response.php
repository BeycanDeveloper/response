<?php

namespace Beycan;

/**
 * A helper class to return meaningful and regular responses.
 * @link https://github.com/BeycanDeveloper/response
 * @author BeycanDeveloper
 * @version 1.0.0
 */
final class Response
{
    /**
     * HTTP Codes
     */
    private const HTTP_OK = 200;
    private const HTTP_BAD_REQUEST = 400;
    private const HTTP_UNAUTHORIZED = 401;
    private const HTTP_FORBIDDEN = 403;
    private const HTTP_NOT_FOUND = 404;
    private const HTTP_NOT_ACCEPTABLE = 406;
    private const HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * HTTP Codes message
     */
    private static $statusTexts = [
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        406 => 'Not Acceptable',
        500 => 'Internal Server Error',
    ];

    /**
     * Method that prints the output as json to the screen
     * @param array $data
     * @param int $statusCode
     */
    private static function json(array $data, int $statusCode)
    {
        http_response_code($statusCode);
        echo json_encode($data);
        die;
    }

    /**
     * Helper method to return some error types in ready form.
     * @param string $message
     * @param string $errorCode
     * @param int $responseCode
     */
    private static function readyErrorResponse($message, $errorCode, $data, int $responseCode)
    {
        $readyMessageText = isset(self::$statusTexts[$responseCode]) ? self::$statusTexts[$responseCode] : null;
        
        self::json([
            'success' => false,
            'errorCode' => $errorCode ? $errorCode : "ER".$responseCode,
            'message' => $message ? $message : $readyMessageText,
            'data' => $data,
        ], $responseCode);
    }

    /**
     * @param string $message
     * @param mixed $data
     */
    public static function success($message = null, $data = null)
    {
        self::json([
            'success' => true,
            'errorCode' => null,
            'message' => $message,
            'data' => $data
        ], self::HTTP_OK);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     * @param int $responseCode
     */
    public static function error($message = null, $data = null, $errorCode = null, int $responseCode = 200)
    {
        self::json([
            'success' => false,
            'errorCode' => $errorCode ? $errorCode : "ER".$responseCode,
            'message' => $message,
            'data' => $data
        ], $responseCode);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     */
    public static function badRequest($message = null, $errorCode = null, $data = null)
    {
        self::readyErrorResponse($message, $errorCode, $data, self::HTTP_BAD_REQUEST);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     */
    public static function unAuthorized($message = null, $errorCode = null, $data = null)
    {
        self::readyErrorResponse($message, $errorCode, $data, self::HTTP_UNAUTHORIZED);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     */
    public static function forbidden($message = null, $errorCode = null, $data = null)
    {
        self::readyErrorResponse($message, $errorCode, $data, self::HTTP_FORBIDDEN);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     */
    public static function notFound($message = null, $errorCode = null, $data = null)
    {
        self::readyErrorResponse($message, $errorCode, $data, self::HTTP_NOT_FOUND);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     */
    public static function notAcceptable($message = null, $errorCode = null, $data = null)
    {
        self::readyErrorResponse($message, $errorCode, $data, self::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param mixed $data
     */
    public static function serverInternal($message = null, $errorCode = null, $data = null)
    {
        self::readyErrorResponse($message, $errorCode, $data, self::HTTP_INTERNAL_SERVER_ERROR);
    }
}