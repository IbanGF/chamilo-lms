<?php
namespace Ddeboer\DataImport\Tests\ValueConverter;

use Ddeboer\DataImport\ValueConverter\MappingValueConverter;

class MappingValueConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Ddeboer\DataImport\Exception\UnexpectedValueException
     * @expectedExceptionMessage Cannot find mapping for value "unexpected value"
     */
    public function testConvert()
    {
        $converter = new MappingValueConverter(array(
            'source' => 'destination'
        ));

        $this->assertSame('destination', $converter->convert('source'));
        $converter->convert('unexpected value');
    }
}
