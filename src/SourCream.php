<?php
namespace SourCream;

/**
 * Sour Cream
 */
class SourCream implements \SessionHandlerInterface
{
    const CACHE_LIMIT_PUBLIC = "public";
    const CACHE_LIMIT_PRIVATE_NO_EXPIRE = "private_no_expire";
    const CACHE_LIMNT_NO_CACHE = "nocache";

    private $isStarted = false;
    private $config;

    /**
     * Sour Cream constructor
     */
    public function __construct( $config = array() )
    {
        $this->setConfig( $config );

        if( !isset( $this->config["dontUseSelf"] ) ){
            $this->setSaveHandlers( $this );
        }  
    }

    public function setConfig( array $config )
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function saveSessionPath( string $path )
    {
    	session_save_path( $path ); 
    }

    public function getSessionId(){
        return session_id();
    }

    public function setSessionId( string $id )
    {
        return session_id( sha1( $id ) );
    }

    public function createSessionId( string $prefix )
    {
        return session_create_id( $prefix );
    }

    public function decode( string $data = null )
    {
        return session_decode( $data );
    }

    public function encode()
    {
        return session_encode();
    }

    public function moduleName( string $module = null )
    {
        return session_module_name( $module );
    }

    public function isRegistered( string $name )
    {
        return session_is_registered( $name );
    }

    public function abort()
    {
        return true;
    }

    public function cacheExpire( string $newCacheExpire = null )
    {
        return session_cache_expire( $newCacheExpire );
    }

    public function sessionCacheLimiter( string $cacheLimiter = null )
    {
        return session_cache_limiter( $cacheLimiter );
    }

    public function name( string $name = null )
    {
        return session_name( $name );
    }

    public function regenerateId( bool $deleteOldSession = false )
    {
        return session_regenerate_id( $deleteOldSession );
    }

    public function registerShutdown()
    {
        session_register_shutdown();
    }

    public function register( mixed $string, mixed $var )
    {
        return session_register( $string, $var );
    }

    public function setSaveHandlers( $open = null, string $close = "close", string $read = "read", string $write = "write", string $destroy = "destroy", string $garbage = "garbage", mixed $object = null )
    {

        if( gettype( $open ) === "object" ){
            $object = $open;
        }

        if( is_array( $open ) && !empty( $open ) ){

            if( !isset( $open["open"] ) ){
                throw new Error( "Specify a function to use for open" ); 
            }
            if( !isset( $open["close"] ) ){
                throw new Error( "Specify a function to use for close" ); 
            }            
            if( !isset( $open["read"] ) ){
                throw new Error( "Specify a function to use for read" ); 
            }
            if( !isset( $open["write"] ) ){
                throw new Error( "Specify a function to use for write" ); 
            }
            if( !isset( $open["destroy"] ) ){
                throw new Error( "Specify a function to use for destroy" ); 
            }            
            if( !isset( $open["garbage"] ) ){
                throw new Error( "Specify a function to use for garbage" ); 
            }

            session_set_save_handler(
                array( $open["object"], $open["open"] ),
                array( $open["object"], $open["close"] ),
                array( $open["object"], $open["read"] ),
                array( $open["object"], $open["write"] ),
                array( $open["object"], $open["destroy"] ),
                array( $open["object"], $open["garbage"] ) 
            );
        }

        if( $object instanceof SourCream\SourCream || class_exists( get_class( $object ) ) ){




            session_set_save_handler( 
                array( &$object, "open" ), 
                array( &$object, $close ), 
                array( &$object, $read ), 
                array( &$object, $write ), 
                array( &$object, $destroy ), 
                array( &$object, $garbage ) 
            );

            // the following prevents unexpected effects when using objects as save handlers
            register_shutdown_function('session_write_close');
        }
    }

    public function sessionStart()
    {
        return session_start();
    }

    public function sessionReset()
    {
        return session_reset();
    }

    public function open( $savepath, $sessionname )
    {
        
        if( $this->isSavePath() ){


            
        }

        return true;
    }

    public function close()
    {
        error_log( print_r( __METHOD__ .":".__LINE__,1 ) );
        return true;
    }

    public function read( $sessionId )
    {
        error_log( print_r( __METHOD__ .":".__LINE__,1 ) );
        return $this->setSessionId( $sessionId );
    }

    public function write( $key, $value )
    {
        error_log( print_r( __METHOD__ .":".__LINE__,1 ) );
        return true;
    }

    public function destroy( $session_id )
    {
        error_log( print_r( __METHOD__ .":".__LINE__,1 ) );
        return session_destroy( $session_id );
    }

    public function garbage( $maxlifetime )
    {
        error_log( print_r( __METHOD__ .":".__LINE__,1 ) );
        true;
    }

    public function gc( $maxlifetime ){
        error_log( print_r( __METHOD__ .":".__LINE__,1 ) );
        return true;
    }

    public function garbageCleanup()
    {
        return session_gc();
    }

    public function isSavePath()
    {
        return (bool)isset( $this->config["savepath"] );
    }

    public function getCookieParams()
    {
        return session_get_cookie_params();
    }

    public function setCookieParams( mixed $lifetime, string $path = "", string $domain = "", bool $secure = false, bool $httponly = false )
    {
        session_set_cookie_params( $lifetime, $path, $domain, $secure, $httponly );
    }

    public function start( array $options = array() )
    {

        if( $this->isStarted ){
            throw new Error( "Session has already been started" );
        }

        $this->isStarted = 1;
        return session_start( $options );
    }

    public function status()
    {
        return session_status();
    }

    public function unRegister( string $name )
    {
        return session_unregister( $name );
    }

    public function unset()
    {
        return session_unset();
    }

    public function writeClose()
    {
        return session_write_close();
    }

}
