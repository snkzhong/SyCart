<?php

class SYLog extends \Slim\Log
{
	public function log($level, $object, $context = array())
    {
        if (!isset(self::$levels[$level])) {
            throw new \InvalidArgumentException('Invalid log level supplied to function');
        } else if ($this->enabled && $this->writer && $level <= $this->level) {
            $message = (string)$object;
            if (count($context) > 0) {
                if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
                    $message .= ' - ' . $context['exception'];
                    unset($context['exception']);
                }
                $message = $this->interpolate($message, $context);
            }
            $message = '['.date('Y-m-d H:i:s').'] ['.self::$levels[$level].'] '.$message;
            return $this->writer->write($message, $level);
        } else {
            return false;
        }
    }
}