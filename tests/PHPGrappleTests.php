<?php
/**
* PHPGrappleTests class
* 
* PHPUnit Test Class
*
*/
require_once( PHPGRAPPLE_DIR . 'PHPGrapple.php' );

class PHPGrappleTests extends PHPUnit_Framework_TestCase {
    protected $tClass;
    protected $fixture =
        "Configure::write( 'lamp' );
        Configure::write( 'true', true );
        Configure::write( \"false\", false );
        Configure::write( 'null', null );
        Configure::write( \"lang\", \"php\");
        Configure::write( 'happy', 'yes');
        Configure::write( 'today', \"4th\");
        Configure::write(    'year', 2012 );
        Configure::write(   'month'  ,   2      );
        Configure::write( 'nextyear', 2013);                                        //10
        Configure::write( 'array', array('An', 'Array', 'As an argument') );
        Configure::write( 'newInstance', new SomeClass(\"Foo\") );
        Configure::write('lastyear',2011);
        Configure::write('tenyears',
            2022
        );
        Configure::write(
            'twentyyears',
            2032
        );
        Configure::write( 'happy', 'yes');
        Configure::write('Back ', 2);Configure::write('back', 'calls'); //17 and 18
        Configure::write( 'variable', \$myVar);
        Configure::write( 'myProperty', \$myObj=>myProp);
        Configure::write( 'myFn', callMyFunc() );
        Configure::write( 'myFnWithParams', callMyFuncWithParams( 'one', 'two' ) );
        Configure::write( 'myFnWithArrayParams', callMyFuncWithParams( array( 1, 2, 3,4) ) );
        Configure::write( 'a', 'c', 'd' );
        Configure::write( 'fourparams', 'build', 'test', 'deploy' );
        Configure::write( 'lastcall', 'abc123' );
    ";
    
    function SetUp() {
        $this->tClass = new PHPGrapple( $this->fixture );  
    }
    
    function testGetterSetter() {
        $PGrap = new PHPGrapple( 'Testing 1 2 3 4 5 6 7 8 9' );
        $this->assertEquals( 'Testing 1 2 3 4 5 6 7 8 9', $PGrap->getSubject() );
        
        $PGrap->setSubject( "//Some PHP Code\n\$a = 1 + 2;\n" );
        $this->assertEquals( "//Some PHP Code\n\$a = 1 + 2;\n", $PGrap->getSubject() );
    }
    function testGetFuncCallParams() {
       
        $this->assertEquals( array('lamp'), $this->tClass->getFuncCallParams( 'Configure::write', 2 )  );   
    }

    function testGetNthFuncCallParams() {
        $results = $this->tClass->getNthFuncCallParams( 9, 'Configure::write', 2 );
        $this->assertEquals( array('month', '2'), $results['params'] );
        
        $results = $this->tClass->getNthFuncCallParams( 1, 'Configure::write', 2 );
        $this->assertEquals( array('lamp'), $results['params'] );

        $results = $this->tClass->getNthFuncCallParams( -1, 'Configure::write', 2 );
        $this->assertEquals( array('lastcall', 'abc123'), $results['params'] );
                
        $results = $this->tClass->getNthFuncCallParams( 'last', 'Configure::write', 2 );
        $this->assertEquals( array('lastcall', 'abc123'), $results['params'] );
        
    }
    
    function testGetAllFuncCallParams() {
        $results = $this->tClass->getAllFuncCallParams( 'Configure::write', 2 );
        //print_r( $results );
        $this->assertEquals( 'lamp', $results[0]['params'][0] );   
        $this->assertEquals( array('true', 'true') , $results[1]['params'] );   
        $this->assertEquals( array('false', 'false') , $results[2]['params'] );   
        $this->assertEquals( array('null', 'null') , $results[3]['params'] );   
        $this->assertEquals( array('lang', 'php') , $results[4]['params'] );   
        $this->assertEquals( array('happy', 'yes') , $results[5]['params'] );   
        $this->assertEquals( array('today', '4th') , $results[6]['params'] );   
        $this->assertEquals( array('year', '2012') , $results[7]['params'] );   
        $this->assertEquals( array('month', '2') , $results[8]['params'] );   
        $this->assertEquals( array('nextyear', '2013') , $results[9]['params'] );   
        $this->assertEquals( array('array', "array('An', 'Array', 'As an argument')") , $results[10]['params'] );   
        $this->assertEquals( array('newInstance', 'new SomeClass("Foo")') , $results[11]['params'] );   
        $this->assertEquals( array('lastyear', '2011') , $results[12]['params'] );   
        $this->assertEquals( array('tenyears', '2022') , $results[13]['params'] );   
        $this->assertEquals( array('twentyyears', '2032') , $results[14]['params'] );   
        $this->assertEquals( array('happy', 'yes') , $results[15]['params'] );   
        $this->assertEquals( array('Back ', '2') , $results[16]['params'] );   
        $this->assertEquals( array('back', 'calls') , $results[17]['params'] );   
        $this->assertEquals( array('variable', '$myVar') , $results[18]['params'] );   
        $this->assertEquals( array('myProperty', '$myObj=>myProp') , $results[19]['params'] );   
        $this->assertEquals( array('myFn', 'callMyFunc()') , $results[20]['params'] );   
        $this->assertEquals( array('myFnWithParams', "callMyFuncWithParams( 'one', 'two' )") , $results[21]['params'] );   
        $this->assertEquals( array('myFnWithArrayParams', 'callMyFuncWithParams( array( 1, 2, 3,4) )') , $results[22]['params'] );   
        $this->assertEquals( array('a', "c', 'd") , $results[23]['params'] );   
        //$this->assertEquals( array('fourparams', "build', 'test', 'deploy" ) , $results[24]['params'] );
        $this->assertEquals( array('lastcall', 'abc123') , $results[25]['params'] );      
    }
    
          
}