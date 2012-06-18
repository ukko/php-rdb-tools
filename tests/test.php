<?php

define('FD', pack('H*','FD'));
define('FC', pack('H*','FC'));
define('FE', pack('H*','FE'));
define('FF', pack('H*','FF'));

define('STRING',    pack('c', '00'));
define('LIST',      pack('c', '01'));
define('SET',       pack('c', '02'));
define('ZSET',      pack('c', '03'));
define('HASH',      pack('c', '04'));
define('ZIPMAP',    pack('c', '05'));
define('ZIPLIST',   pack('c', '10'));
define('INTSET',    pack('c', '11'));
define('ZSETZLST',  pack('c', '12'));
define('HASHZLST',  pack('c', '13'));

define('B_00', 0 );
define('B_01', 1 << 0 );
define('B_10', 1 << 1 );
define('B_11', B_01 || B_10 );

$handle     = fopen( __DIR__ . '/dump2.rdb', 'r');

// head
$data       = fread( $handle, 9 );
$head       = unpack('a5redis/a4format', $data);
echo ' === HEAD === ' . PHP_EOL . 'redis: ' . $head['redis'] . PHP_EOL . 'format: ' . (int)$head['format'] . PHP_EOL;



while ( ! feof( $handle ) )
{
    $data       = fread( $handle, 1 );

    switch ( $data )
    {
        // database selector
        case FE:
        {
            $data       = fread( $handle, 1 );
            $selector   = unpack('H2db', $data);
            echo 'db: ' . (int)$selector['db'] . PHP_EOL ;
            break;
        }
        // expiry time in seconds
        case FD:
        {
            var_dump( __LINE__, unpack('h*', $data) );
            break;
        }
        // expiry time in ms
        case FC:
        {
            var_dump( __LINE__, unpack('h*', $data) );
            break;
        }
        case FF:
        {
            var_dump( __LINE__,  unpack('h*', $data) );
            break;
        }
        // KEY => VALUE
        default:
        {
            if ( $data == STRING )
            {
                // Читаем ключ
                $data       = fread( $handle, 1 );
                $length     = unpack( 'clength', $data );
                $key        = fread( $handle, $length['length'] );

                $data       = fread( $handle, 1 );

                $data       = fread( $handle, 1 );
                $value      = unpack( 'C', $data );

                echo 'key: ' . $key . PHP_EOL . 'value: ' . $value[1] . PHP_EOL;
            }
            elseif ( $data === HASH )
            {
                var_dump( __LINE__, $data );
            }
            elseif ( $data == HASHZLST )
            {
                // Читаем ключ
                $data       = fread( $handle, 1 );
                $length     = unpack( 'clength', $data );
                $key        = fread( $handle, $length['length'] );

                // Значение
                $data       = fread( $handle, 1 );

                if ( $data & B_00 )
                {
                    echo '00';
                }
                elseif ( $data & B_01 )
                {
                    echo '01';
                }
                elseif ( $data & B_10 )
                {
                    echo '10';
                }
                elseif ( $data & B_11 )
                {
                    echo '11';
                }
                else
                {
                    echo '--' . PHP_EOL;
                }

                var_dump( $data, unpack('H*', $data) );
                die();
            }
            else
            {
                die(var_dump( __LINE__, $data, unpack('H*', $data)));
            }



//            var_dump( $data, $value );


//            fclose($handle);
//            die();
            break;
        }
    }
}







//print PHP_EOL . '----' . PHP_EOL . var_export($data, 1);

fclose($handle);
