<?php
/**
* PHPGrappleClass
*/
class PHPGrappleClass {
    
    protected $subject;
    
    /**
    * __construct
    * 
    * @param mixed $subject
    * @return PHPGrappleClass
    */
    public function __construct( $subject='' ) { 
        $this->setSubject( $subject ); 
    }
    
    /**
    * subject getter
    * 
    * @return string
    */
    public function getSubject() { 
        return $this->subject; 
    }
    
    /**
    * subject setter
    * 
    * @param mixed $subject
    * @return null
    */
    public function setSubject( $subject ) { 
        $this->subject = $subject; 
    }
    
    /**
    * returns class names  found in $subject
    * Consider moving to PHPGrapple class 
    * 
    * @return array   
    */
    public function getClasses( ) {
        $regex = "class\s*([a-zA-Z][a-zA-Z0-9]+)";
        preg_match_all( "/$regex/", $this->subject, $matches );    
        
        if ( array_key_exists(1, $matches) ) {
            return $matches[1];
        } else {
            return array();
        }           
    }
    
    /**
    * returns total numbers of classes found in $subject
    * Consider moving to PHPGrapple class  
    * 
    * @return int  
    */
    public function getClassCount( ) {
        return count( $this->getClasses() );
    }
    
    /**
    * extract all property names
    * @return array 
    */
    public function getProperties( ) {
        $regex = "((protected|public|private|var)?\s*\\$([a-zA-Z][a-zA-Z0-9]+))";
        preg_match_all( "/$regex/", $this->subject, $matches );    
        
        if ( array_key_exists(3, $matches) ) {
            return $matches[3];
        } else {
            return array();
        }
    }

    /**
    * counts number of class properties 
    * 
    * @return int
    */
    public function getPropertyCount( ) {
        return count( $this->getProperties( ) );
    }
    
    /**
    * extract all method names
    * 
    * @return array()        
    */
    public function getMethods( ) {
        $regex = "(protected|public|private)?\s*function\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*\(";
        preg_match_all( "/$regex/", $this->subject, $matches );           
        
        if ( array_key_exists(2, $matches) ) {
            return $matches[2];
        } else {
            return array();
        }
    }

    /**
    * extract all method names of type(visibility): public, private, protected 
    * 
    * @param mixed $visibility
    * @return array
    */
    public function getMethodsByType( $visibility ) {
        if ( $visibility != 'public' && $visibility != 'private' && $visibility != 'protected' ) {
            throw new InvalidArgumentException('visibility must be public, private, or protected');
        }

        $regex = "(" . $visibility. ")\s*function\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*\(";
        preg_match_all( "/$regex/", $this->subject, $matches );    
        if ( array_key_exists(2, $matches) ) {
            return $matches[2];
        } else {
            return array();
        }         
    }
    
    /**
    * count methods, optionally of type(visibility): public, private, protected
    *     
    * @param mixed $vis
    * @return int
    */
    public function getMethodCount( $visibility='' ) {
        if ( !empty($visibility) ) { 
            if ( $visibility != 'public' && $visibility != 'private' && $visibility != 'protected' ) {
                throw new InvalidArgumentException('visibility must be public, private, or protected');
            }
            return count( $this->getMethodsByType($visibility) );
        }
        
        return count( $this->getMethods() );
    }

    /**
    * Returns string, everything inside 'class $clsName { }'
    * 
    * @param mixed $clsName
    */
    public function getClassSrc( $clsName ) {
        $regex = "class\s*{\s*}"; 
        preg_match( "/$regex/", $this->subject, $matches );   
        //print_r( $matches );
    }

}