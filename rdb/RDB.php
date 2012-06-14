<?php
namespace RDB;

/**
 */
class RDB
{

    /**
     * @var string
     */
    protected $file     = null;

    /**
     * @var int
     */
    protected $format   = null;

    protected $fileType = null;

    /**
     * @param null $file
     */
    public function __construct( $file = null )
    {
        if ( $file )
        {
            $this->setFile( $file );
        }
    }

    /**
     * @param null $file
     */
    public function setFile($file)
    {

        if ( ! file_exists( $file ) )
        {
            throw new \RDB\ExceptionFile( 'File doesnot exists' );
        }
        $this->file = $file;
    }

    /**
     * @return null
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getFileType()
    {

    }

    public function getFormat()
    {

    }

    public function read()
    {
        $fh     = fopen( $this->getFile(), "r");
        $file   = fread( $fh, filesize( $this->getFile() ) );

        var_dump( unpack("a5redis/a4format", $file) );

//        $this->setFileType( unpack("25ffd", $file) );

        print $file;

        fclose($fh);
    }

    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @param int $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

}

class ExceptionFile extends \Exception {}
