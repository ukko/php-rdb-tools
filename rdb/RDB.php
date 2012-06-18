<?php
namespace RDB;

/**
 */
class RDB
{

    /**
     * RDB filepath
     *
     * @var string
     */
    protected $file     = null;

    /**
     * Version RDB file
     *
     * @var int
     */
    protected $version   = null;

    /**
     * String REDIS
     *
     * @var string
     */
    protected $mime = null;


    /**
     *
     * @param string $file
     */
    public function __construct( $file = null )
    {
        if ( $file )
        {
            $this->setFile( $file );
        }
    }

    /**
     *
     * @param string $file
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

    public function getMime()
    {

    }

    public function getVersion()
    {

    }

    public function read()
    {
        $fh     = fopen( $this->getFile(), "r");
        $file   = fread( $fh, filesize( $this->getFile() ) );

        var_dump( unpack("a5redis/a4format/H2selector/H2db/H2", $file) );
        var_dump( unpack("H*", $file) );

//        $this->setFileType( unpack("25ffd", $file) );

        print $file;

        fclose($fh);
    }

    public function setMime($fileType)
    {
        $this->mime = $fileType;
    }

    /**
     * @param int $format
     */
    public function setVersion($format)
    {
        $this->version = $format;
    }

}

class ExceptionFile extends \Exception {}
