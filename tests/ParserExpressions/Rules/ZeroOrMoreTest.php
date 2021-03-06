<?php
use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\Rules\Row;
use GetSky\ParserExpressions\Rules\ZeroOrMore;

class ZeroOrMoreTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertInstanceOf(
            'GetSky\ParserExpressions\Rules\AbstractRule',
            $this->getObject()
        );
    }

    public function testCreateZeroOrMore()
    {
        $rule = $this->getMockBuilder(Row::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $name = "ScanZeroOrMore";
        $test = new ZeroOrMore($rule, $name);
        $attribute = $this->getAccessibleProperty(ZeroOrMore::class, 'rule');
        $fName = $this->getAccessibleProperty(ZeroOrMore::class, 'name');

        $this->assertSame($rule, $attribute->getValue($test));
        $this->assertSame($name, $fName->getValue($test));
    }

    public function testScan()
    {
        $mock = $this->getObject();
        $rule = $this->getAccessibleProperty(ZeroOrMore::class, 'rule');

        $result = $this->getMockBuilder(Result::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();

        $result
            ->expects($this->exactly(2))
            ->method('getValue')
            ->will($this->returnValue(1));

        $context = $this->getMockBuilder(Context::class)
            ->setMethods(['value', 'getCursor', 'setCursor'])
            ->disableOriginalConstructor()
            ->getMock();

        $context
            ->expects($this->exactly(4))
            ->method('getCursor')
            ->will($this->onConsecutiveCalls(1,2,3,1));
        $context
            ->expects($this->exactly(2))
            ->method('setCursor');

        $subrule = $this->getMockBuilder(Row::class)
            ->setMethods(['scan'])
            ->disableOriginalConstructor()
            ->getMock();
        $subrule->expects($this->exactly(5))
            ->method('scan')
            ->will($this->onConsecutiveCalls($result, $result, true, false,
                false));

        $rule->setValue($mock, $subrule);

        $this->assertInstanceOf(Result::class, $mock->scan($context));

        $this->assertSame(true, $mock->scan($context));
    }

    private function getObject()
    {
        return $this->getMockBuilder(ZeroOrMore::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getAccessibleProperty($class, $name)
    {
        $property = new ReflectionProperty($class, $name);
        $property->setAccessible(true);
        return $property;
    }
}
