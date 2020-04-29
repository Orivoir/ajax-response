<?php

namespace Ajax\Util;

class StatusText {

    const ASSOCIATE_STATUS_TEXT = [

        "success" => [
            "200" => "success",
            "201" => "Created",
            "202" => "Accepted",
            "203" => "Non-Authoritative Information",
            "204" => "No Content",
            "205" => "Reset Content",
            "206" => "Partial Content",
            "207" => "Multi-Status",
            "208" => "Already Reported",
            "210" => "Content Different",
            "216" => "IM Used"
        ] ,
        "redirect" => [
            "300" => "Multiple Choices",
            "301" => "Moved Permanently",
            "302" => "Moved ( Found )",
            "303" => "See Other",
            "304" => "Not Modified",
            "305" => "Use Proxy",
            "306" => "Switch Proxy",
            "307" => "Temporary Redirect",
            "308" => "Permanent Redirect",
            "310" => "Too Many Redirects"
        ],
        "error-browser" => [
            "400" => "Bad Request",
            "401" => "Unauthorized",
            "402" => "Payment Required",
            "403" => "Forbidden",
            "404" => "Not Found",
            "405" => "Method Not Allowed",
            "406" => "Not Acceptable",
            "407" => "Proxy Authentication Required",
            "408" => "Request Time-out",
            "409" => "Conflict",
            "410" => "Gone",
            "411" => "Length Required",
            "412" => "Precondition Failed",
            "413" => "Request Entity Too Large",
            "414" => "Request-URI Too Long",
            "415" => "Unsupported Media Type",
            "416" => "Requested range unsatisfiable",
            "417" => "Expectation failed",
            "418" => "I’m a teapot", // RFC 2324 - 1er avril 1998, Hyper Text Coffee Pot Control Protocol.
            "421" => "Bad mapping / Misdirected Request",
            "422" => "Unprocessable entity",
            "423" => "Locked",
            "424" => "Method failure",
            "425" => "Unordered Collection",
            "426" => "Upgrade Required",
            "428" => "Precondition Required",
            "429" => "Too Many Requests",
            "431" => "Request Header Fields Too Large",
            "449" => "Retry With",
            "450" => "Blocked by Windows Parental Controls",
            "451" => "Unavailable For Legal Reasons",
            "456" => "Unrecoverable Error"
        ],
        "error-server" => [
            "500" => "Internal Server Error",
            "501" => "Not Implemented",
            "502" => "Bad Gateway ou Proxy Error",
            "503" => "Service Unavailable",
            "504" => "Gateway Time-out",
            "505" => "HTTP Version not supported",
            "506" => "Variant Also Negotiates",
            "507" => "Insufficient storage",
            "508" => "Loop detected",
            "509" => "Bandwidth Limit Exceeded",
            "510" => "Not extended",
            "511" => "Network authentication required"
        ]
    ] ;

    const ASSOCIATE_STATUS_TYPE = [
        "2" => "success",
        "3" => "redirect",
        "4" => "error-browser",
        "5" => "error-server"
    ] ;

    private $status = "200";

    private $statusText = NULL;

    private $statusType = NULL;

    public function __construct( int $statusCode = 200 ) {

        $this->status = (string) $statusCode;
    }

    public function getStatusText(): ?string {

        $statusType = $this->getStatusType();

        if( \is_null( $statusType ) ) {

            return NULL;
        }

        $codesText = self::ASSOCIATE_STATUS_TEXT[ $statusType ] ;

        return isset( $codesText[ $this->status ] ) ? $codesText[ $this->status ]: NULL;
    }

    public function getStatusType(): ?string {

        if( !\is_null( $this->statusType ) ) {

            return $this->statusType;
        }

        $statusType = NULL;

        foreach( self::ASSOCIATE_STATUS_TYPE as $key => $val ) {

            if( $this->status[0] == $key ) {

                $statusType = $val;
            }
        }

        if( !\is_null( $statusType ) ) {

            $this->statusType = $statusType;
        }

        return $statusType;
    }

} ;