<?php
namespace kordar\ams\web;

use yii\base\UserException;

class AmsException extends UserException
{
    /**
     * @var int HTTP status code, such as 403, 404, 500, etc.
     */
    public $statusCode;


    /**
     * Constructor.
     * @param int $status HTTP status code, such as 404, 500, etc.
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($status, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($message, $status, $previous);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        if (isset(Response::$httpStatuses[$this->statusCode])) {
            return Response::$httpStatuses[$this->statusCode];
        }

        return 'Error';
    }
}