<?php

namespace Ajax;

use Ajax\Util\StatusText;

class Response {

    private static $isAutoStatusCode = true;
    private static $isAutoStatusText = true;

    private static $nameAutoStatusCode = "statusCode";
    private static $nameAutoStatusText = "statusText";

    private static $details = [];

    private $response = [];
    private $code = 200;

    private $isReady = false;

    public static function getDetails(): array {

        return self::$details;
    }

    public static function addDetails( string $key, $val ): int {

        self::$details[ $key ] = $val;

        return \count( self::$details );
    }

    public static function deleteDetails( $key = NULL ) {

        if( \is_null( $key )  ) {

            self::$details = [] ;

            return 0;

        } else if(
            \is_string( $key ) &&
            isset( self::$details[ $key ] )
        ) {

            unset( self::$details[ $key ] ) ;

            self::$details = \array_values( self::$details ) ;

            return \count( self::$details ) ;
        }

        return false;
    }

    public static function getIsAutotStatusCode(): bool {

        return self::$isAutoStatusCode;
    }

    public static function setIsAutotStatusCode( bool $isAutoStatusCode ): bool {

        self::$isAutoStatusCode = $isAutoStatusCode;

        return self::$isAutoStatusCode;
    }

    public static function getIsAutoStatusText(): bool {

        return self::$isAutoStatusText;
    }

    public static function setIsAutoStatusText( bool $isAutoStatusText ): bool {

        self::$isAutoStatusText = $isAutoStatusText;

        return self::$isAutoStatusText;
    }

    public static function getNameAutoStatusCode(): string {

        return self::$nameAutoStatusCode;
    }

    public static function setNameAutoStatusCode( string $nameAutoStatusCode ): string {

        self::$nameAutoStatusCode = $nameAutoStatusCode;

        return self::$nameAutoStatusCode;
    }

    public static function getNameAutoStatusText(): string {

        return self::$nameAutoStatusText;
    }

    public static function setNameAutoStatusText( string $nameAutoStatusText ): string {

        self::$nameAutoStatusText = $nameAutoStatusCode;
    }

    public function getResponse(): array {

        return $this->response;
    }

    public function getCode(): int {

        return $this->code;
    }

    public function addAutoValue() {

        if( self::$isAutoStatusCode ) {

            $this->response[ self::$nameAutoStatusCode ] = $this->code;
        }

        if( self::$isAutoStatusText ) {

            $statusText = ( new StatusText( $this->code ) )->getStatusText();

            if( !\is_null( $statusText ) ) {

                $this->response[ self::$nameAutoStatusText ] = $statusText;
            }
        }

    }

    public function send( string $charset = "utf-8" ): void {

        \header("Content-Type: application/json; charset={$charset}");

        if( $this->isReady ) {

            \http_response_code( (int) $this->code ) ;

            echo \json_encode( $this->response ) ;

        } else {

            self::setDefault() ;

            $this->prepare( [
                "_response-auto-generate" => "you have attempt send response with AjaxResponse as bad response",
                "_prepare" => "you should call `bool prepare( ?array response, ?int code )` method before call `void send( ?string charset )` method"
            ], 500 ) ;

            $this->send() ;
        }
    }

    public function prepare( $response, int $code = 200 ): bool {

        if( \is_string( $response ) ) {

            $details = $response;
            $response = [];
            $response['details'] = $details;
            unset( $details );

        } else if( \is_null( $response ) ) {

            $response = [];
        }

        if( \is_array( $response ) ) {

            $this->response = $response;
            $this->code = $code;

            $this->addAutoValue();

            $this->isReady = true;

            return true;

        } else {

            $this->isReady = false;

            return false;
        }

    }

    private static function setDefault(): void {

        self::$isAutoStatusCode = true;
        self::$isAutoStatusText = true;
        self::$nameAutoStatusCode = "statusCode";
        self::$nameAutoStatusText = "statusText";
    }

} ;
