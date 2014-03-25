<?php
namespace Alsar\Exception;

class MethodNotImplementedException extends \Exception
{
    protected $messageTemplate = 'Method "%s" in class "%s" is not implemented yet.';

    public function __construct()
    {
        $callerTrace = debug_backtrace()[1];

        $this->message = sprintf($this->messageTemplate, $callerTrace['function'], $callerTrace['class']);
    }
}
