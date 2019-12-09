<?php
/** 
 * Class to write to log files with the correct logging format
 */
class Logger
{
/** @var The file to write the log output to */
private $filename = "";
/** @var Memory buffer for the log content before writing to the file */
private $buffer = "";

/**
 * The constructor for the logger
 *
 * @param $filename The file to write the log output to
 */
function __construct ($filename)
{
$this->filename = $filename;
}

/**
 * Frees resources on shutdown
 */
function __destruct ()
{
$this->save ();
}

/**
 * @return The file the logger will write to
 */
function getFilename ()
{
return $this->filename;
}

/**
 * Updates the file the logger writes to
 *
 * @param $newFilename The new file to write to
 */
function setFilename ($newFilename)
{
$this->filename = $newFilename;
}

/**
 * Writes a message to the buffer
 *
 * @param $type The type of message to write
 * @param $service The service that generated the message
 * @param $message The message to write
 */
private function write ($type, $service, $message)
{
$this->buffer .= "{date (DATE_ATOM)} - {$service}: {$message}\n";

return $this;
}

/**
 * Writes a debug message to the buffer
 *
 * @param $service The service that generated the message
 * @param $message The message to write
 */
function debug ($service, $message)
{
return $this->write ('debug', $service, $message);
}

/**
 * Writes an error message to the buffer
 *
 * @param $service The service that generated the message
 * @param $message The message to write
 */
function error ($service, $message)
{
return $this->write ('error', $service, $message);
}

/**
 * Writes a warning message to the buffer
 *
 * @param $service The service that generated the message
 * @param $message The message to write
 */
function warning ($service, $message)
{
return $this->write ('warning', $service, $message);
}

/**
 * Writes an info message to the buffer
 *
 * @param $service The service that generated the message
 * @param $message The message to write
 */
function info ($service, $message)
{
return $this->write ('info', $service, $message);
}

/**
 * Writes the messages in the buffer to file
 */
function save ()
{
$fp = fopen ($this->filename, 'ab+');
fwrite($fp, $this->buffer);
fclose ($fp);

$this->buffer = "";
return $this;
}
};