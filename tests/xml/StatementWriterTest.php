<?php 
use Tests\TestCase;
use App\Vc\Lib\Engine\XMLStatementWriter;


class StatementWriterTest extends TestCase
{
    function testStaticString()
    {
        $l_parser=new XMLStatementWriter();
        $l_parser->setObjectAttribute('bla','xx', 'zzz');
        $l_code=$l_parser->getCode();
        $this->assertEquals("\n\$this->gui->bla->setxx(new \\App\\Vc\\Lib\\Engine\\Data\\DynamicStaticValue('zzz'));", $l_code);
    }
    
    function testVar()
    {
        $l_writer=new XMLStatementWriter();
        $l_return=$l_writer->parseToDvData("\${xx}");
        $this->assertEquals("new \\App\\Vc\\Lib\\Engine\\Data\\DynamicVarValue('xx')",$l_return);
    }
}