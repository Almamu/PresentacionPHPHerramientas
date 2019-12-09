<?php
/**
 * Class to write to log files with the correct logging format
 */
class Logger
{
    /** @var string The file to write the log output to */
    private string $filename = "";
    /** @var string Memory buffer for the log content before writing to the file */
    private string $buffer = "";

    /**
     * The constructor for the logger
     *
     * @param string $filename The file to write the log output to
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Frees resources on shutdown
     */
    public function __destruct()
    {
        $this->save();
    }

    /**
     * @return string The file the logger will write to
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Updates the file the logger writes to
     *
     * @param string $newFilename The new file to write to
     */
    public function setFilename($newFilename): void
    {
        $this->filename = $newFilename;
    }

    /**
     * Writes a message to the buffer
     *
     * @param string $type The type of message to write
     * @param string $service The service that generated the message
     * @param string $message The message to write
     */
    private function write(string $type, string $service, string $message): self
    {
        $this->buffer .= "{date (DATE_ATOM)} - {$service}: {$message}\n";

        return $this;
    }

    /**
     * Writes a debug message to the buffer
     *
     * @param string $service The service that generated the message
     * @param string $message The message to write
     */
    public function debug(string $service, string $message): self
    {
        return $this->write('debug', $service, $message);
    }

    /**
     * Writes an error message to the buffer
     *
     * @param string $service The service that generated the message
     * @param string $message The message to write
     */
    public function error(string $service, string $message): self
    {
        return $this->write('error', $service, $message);
    }

    /**
     * Writes a warning message to the buffer
     *
     * @param string $service The service that generated the message
     * @param string $message The message to write
     */
    public function warning(string $service, string $message): self
    {
        return $this->write('warning', $service, $message);
    }

    /**
     * Writes an info message to the buffer
     *
     * @param string $service The service that generated the message
     * @param string $message The message to write
     */
    public function info(string $service, string $message): self
    {
        return $this->write('info', $service, $message);
    }

    /**
     * Writes the messages in the buffer to file
     */
    public function save(): self
    {
        $fp = fopen($this->filename, 'ab+');

        if ($fp === false)
        	return $this;
        
        fwrite($fp, $this->buffer);
        fclose($fp);

        $this->buffer = "";
        return $this;
    }
};
