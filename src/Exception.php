<?php
namespace Shangpeng\Printer;

class Exception extends \Exception
{
    /**
     * http状态码
     * @var int
     */
    protected $httpcode = 0;

    /**
     * Exception constructor.
     * @param string $errormsg
     * @param int $httpcode
     * @param int $errorcode
     * @param \Throwable|null $previous
     */
    public function __construct($errormsg, $httpcode, $errorcode, \Throwable $previous = null) {
        $this->httpcode = $httpcode;
        parent::__construct($errormsg, $errorcode, $previous);
    }

    /**
     * 获取http状态码
     * @return int
     */
    public function getHttpcode()
    {
        return $this->httpcode;
    }
}
