<?php


use PHPUnit\Framework\TestCase;

class EscaleraServiceTest extends TestCase
{

    private EscaleraService $escaleraService;
    protected function setUp(): void
    {
        $this->escaleraService=new EscaleraService();
    }

    public function testExecute()
    {
        $this->assertEquals(1,$this->escaleraService->execute(1));
    }
    public function testExecuteValueTwo()
    {
        $this->assertEquals(2,$this->escaleraService->execute(2));
    }
    public function testExecuteValueThree()
    {
        $this->assertEquals(3,$this->escaleraService->execute(3));
    }
    public function testExecuteValueFive()
    {
        $this->assertEquals(8,$this->escaleraService->execute(5));
    }

    public function testExecuteInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->escaleraService->execute("hola");
    }
    public function testExecuteNullValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->escaleraService->execute(null);
    }

}
