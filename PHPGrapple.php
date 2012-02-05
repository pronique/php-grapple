<?php

class PHPGrapple {
    
    protected $subject;
    protected $paramCountHint = array(
        'usort'=>2,'uksort'=>2,'uasort'=>2,'array_pad'=>3,'array_key_exists'=>2,
        'array_fill'=>2,'array_fill_key'=>2,'array_combine'=>2,'chunk_split'=>3,
        'str_replace'=>3
    );
    
    public function __construct( $subject='' ) { $this->setSubject( $subject ); }
    public function getSubject() { return $this->subject; }
    public function setSubject( $subject ) { $this->subject = $subject; }
        
    public function getFuncCallParams( $func, $num_params=1 ) {
        $base_pattern = '\s*\(\s*[\'"](.*?)[\'"]\s*,?\s*[\'"]?(.*?)[\'"]?\s*\)\s*;';
        preg_match( '/' . $func . $base_pattern . '/', $this->subject, $matches );

        unset( $matches[0] );
        foreach( $matches as $match ) {
            if ( $match != '' ) {
                $results[] = $match;
            }
        }
        return $results;
    }

    public function getNthFuncCallParams( $indx, $func, $num_params=1 ) {
        $base_pattern = '\s*\(\s*[\'"](.*?)[\'"]\s*,?\s*[\'"]?(.*?)[\'"]?\s*\)\s*;';
        preg_match_all( '/' . $func . $base_pattern . '/', $this->subject, $matches );
        
        if ( $indx == -1 || $indx == 'last' ) {
            $targetKey = count( $matches[0] ) - 1;
        } else {
            $targetKey =  $indx - 1;
        }
        if ( !array_key_exists( $targetKey, $matches[0] ) ) {
            return false;
        } else {
            $results = array( 'entire'=>str_replace( "\n", "", $matches[0][$targetKey] ) );   
        }
        unset( $matches[0] );
        foreach( $matches as $match ) {
            if ( array_key_exists( $targetKey, $match ) ) {
                if ( $match[$targetKey] != '' ) {
                    $results['params'][] =  $match[$targetKey];
                }
            }
        }
        return $results;
    }

    public function getAllFuncCallParams( $func, $num_params=1 ) {
        $base_pattern = '\s*\(\s*[\'"](.*?)[\'"]\s*,?\s*[\'"]?(.*?)[\'"]?\s*\)\s*;';
        preg_match_all( '/' . $func . $base_pattern . '/', $this->subject, $matches );
        
        foreach ( $matches[0] as $key=>$entire_match ) {
            for( $i=1; $i <= $num_params; $i++) {
                if ( $matches[$i][$key] != '' ) {
                    $results[$key]['params'][] = $matches[$i][$key];
                }
            }

            $results[$key]['entire'] = str_replace( "\n", "", $entire_match );
        }
        
        return $results;
    }


}