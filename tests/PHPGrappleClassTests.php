<?php
/**
* PHPGrappleClassTests class
* 
* PHPUnit Test Class
*
*/
require_once( PHPGRAPPLE_DIR . 'PHPGrappleClass.php' );

class PHPGrappleClassTests extends PHPUnit_Framework_TestCase {
    protected $tClass;
    protected $fixtures = array(
        "singleclass"=>"
/**
* MyClass Class
* Some more comments
*/
class MyClass extends BaseClass {

    var \$myProp;
    var \$myPropAssign1 = 'Foo String';
    var \$myPropAssign2 = \"Foo String\";
    var \$myPropAssignArr1 = array( 1, 2, 3 );
    var \$myPropAssignArr2 = array( \"one\", 'two', \"three\");
    var \$myPropAssignArr3 = array( \"one\"=>\"one\", \"two\"=>\"two\", \"three\"=>\"three\" );
    
    protected \$myProtProp;
    protected \$myProtPropAssign1 = 'Foo String';
    protected \$myProtPropAssign2 = \"Foo String\";
    protected \$myProtPropAssignArr1 = array( 1, 2, 3 );
    protected \$myProtPropAssignArr2 = array( \"one\", 'two', \"three\");
    protected \$myProtPropAssignArr3 = array( \"one\"=>\"one\", \"two\"=>\"two\", \"three\"=>\"three\" );

    private \$myPrivProp;
    private \$myPrivPropAssign1 = 'Foo String';
    private \$myPrivPropAssign2 = \"Foo String\";
    private \$myPrivPropAssignArr1 = array( 1, 2, 3 );
    private \$myPrivPropAssignArr2 = array( \"one\", 'two', \"three\");
    private \$myPrivPropAssignArr3 = array( \"one\"=>\"one\", \"two\"=>\"two\", \"three\"=>\"three\" );
    
    public \$myPubProp;
    public \$myPubPropAssign1 = 'Foo String';
    public \$myPubPropAssign2 = \"Foo String\";
    public \$myPubPropAssignArr1 = array( 1, 2, 3 );
    public \$myPubPropAssignArr2 = array( \"one\", 'two', \"three\");
    public \$myPubPropAssignArr3 = array( \"one\"=>\"one\", \"two\"=>\"two\", \"three\"=>\"three\" );
    
    public function __construct() {
        
    }

    /**
    * A comment before a method
    */
    protected function myProtMethod() {
        //A Comment inside a method
        \$a = 1 + 2;
        return \$a;
    }
    
    /**
    * A comment before a method
    */
    private function myPrivMethod() {
        //A Comment inside a method
        \$a = 1 + 2;
        return \$a;
    }
        
    /**
    * A comment before a method
    */
    public function myPubMethod() {
        //A Comment inside a method
        \$a = 1 + 2;
        return \$a;
    }
    
    /**
    * A comment before a method
    */
    function myMethod() {
        //A Comment inside a method
        \$a = 1 + 2;
        return \$a;
    }
    
} //Ending Comment
        ",
        'multipleclasses'=>"
class MyClass1 {
    protected \$prop= 'prop';
    public function fooMethod() {
    
    }
}
class MyClass2 {
    public \$prop= 'prop';
    public function fooMethod() {
    
    }
}
class MyClass3 {
    protected \$prop= 'prop';
    public function fooMethod() {
    
    }
}
        ",
        "nospaces"=>"class MyClassNoSpaces{protected function foo(){echo \"test\";}}"
    ); //end protected $fixtures
    
    function SetUp() {
        $this->tClass = new PHPGrappleClass( $this->fixtures['singleclass'] );  
    }
    
    function testGetterSetter() {
        $PGrap = new PHPGrappleClass( 'Testing 1 2 3 4 5 6 7 8 9' );
        $this->assertEquals( 'Testing 1 2 3 4 5 6 7 8 9', $PGrap->getSubject() );
        
        $PGrap->setSubject( "//Some PHP Code\n\$a = 1 + 2;\n" );
        $this->assertEquals( "//Some PHP Code\n\$a = 1 + 2;\n", $PGrap->getSubject() );
    }

    function testGetClasses() {
        $this->tClass->setSubject( $this->fixtures['multipleclasses'] );
        $this->assertEquals( array('MyClass1', 'MyClass2', 'MyClass3'), $this->tClass->getClasses() );            
    }
    
    function testGetClassCount() {
        $this->tClass->setSubject( $this->fixtures['multipleclasses'] );
        $this->assertEquals( 3, $this->tClass->getClassCount() );    
    }
    
    function testGetProperties() {
        $this->tClass->setSubject( $this->fixtures['singleclass'] );
        $results = $this->tClass->getProperties( 'MyClass' );

        $expected =  Array (
            'myProp','myPropAssign1','myPropAssign2','myPropAssignArr1','myPropAssignArr2','myPropAssignArr3',
            'myProtProp','myProtPropAssign1','myProtPropAssign2','myProtPropAssignArr1','myProtPropAssignArr2','myProtPropAssignArr3',
            'myPrivProp','myPrivPropAssign1','myPrivPropAssign2','myPrivPropAssignArr1','myPrivPropAssignArr2','myPrivPropAssignArr3',
            'myPubProp','myPubPropAssign1','myPubPropAssign2','myPubPropAssignArr1','myPubPropAssignArr2','myPubPropAssignArr3'
         );

        $this->assertEquals( $expected, $this->tClass->getProperties( 'MyClass' )  );   
    }
    
    function testGetPropertyCount() {
        $this->tClass->setSubject( $this->fixtures['singleclass'] );
        $this->assertEquals( 24, $this->tClass->getPropertyCount( 'MyClass' )  );   
    }
    
    function testGetMethods() {
        $this->tClass->setSubject( $this->fixtures['singleclass'] );
        $results = $this->tClass->getMethods( 'MyClass' );
        $expected =  Array( '__construct','myProtMethod', 'myPrivMethod', 'myPubMethod', 'myMethod' );
        $this->assertEquals( $expected, $results  );   
    }

    function testGetMethodsByType() {
        $this->tClass->setSubject( $this->fixtures['singleclass'] );
        $results = $this->tClass->getMethodsByType( 'protected' );
        $expected =  Array( 'myProtMethod' );
        $this->assertEquals( $expected, $results  ); 
         
        $results = $this->tClass->getMethodsByType( 'public' );
        $expected =  Array( '__construct', 'myPubMethod' );
        $this->assertEquals( $expected, $results  );  

        $results = $this->tClass->getMethodsByType( 'private' );
        $expected =  Array( 'myPrivMethod' );
        $this->assertEquals( $expected, $results  );       
    }
    
    function testGetMethodCount() {
        $this->tClass->setSubject( $this->fixtures['singleclass'] );
        $this->assertEquals( 5, $this->tClass->getMethodCount( )  );   
        
        $this->assertEquals( 1, $this->tClass->getMethodCount( 'private' )  );
         
        $this->assertEquals( 1, $this->tClass->getMethodCount( 'protected' )  );
         
        $this->assertEquals( 2, $this->tClass->getMethodCount( 'public' )  ); 
    }

    function testGetClassSrc() {
        $this->tClass->setSubject( $this->fixtures['singleclass'] );
        $result = $this->tClass->getClassSrc( 'MyClass' ); 
        //$this->assertEquals( 'foo', $result  );   
    }          
}