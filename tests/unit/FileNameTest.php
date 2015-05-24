<?php

use Sahib\Elegan\Support\FileName;

class FileNameTest extends \Codeception\TestCase\Test
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Sahib\Elegan\Support\FileName
     */
    protected $fileName;

    protected function _before()
    {
        $this->fileName = new FileName();
    }

    protected function _after()
    {
    }

    public function test_split()
    {
        // File name with extension.
        $fileParts = $this->fileName->split('foo-bar.jpg');
        $this->assertEquals(['foo-bar', 'jpg'], $fileParts);

        $fileParts = $this->fileName->split('foo-bar.baz.jpg');
        $this->assertEquals(['foo-bar.baz', 'jpg'], $fileParts);

        // File name without extension.
        $fileParts = $this->fileName->split('foo-bar');
        $this->assertEquals(['foo-bar', ''], $fileParts);
    }

    public function test_add_counter()
    {
        // File name with extension.
        $fileName = $this->fileName->addCounter('foo-bar.jpg', 5);
        $this->assertEquals('foo-bar-5.jpg', $fileName);

        // File name without extension, also with different separator.
        $fileName = $this->fileName->addCounter('foo-bar', 20, '__');
        $this->assertEquals('foo-bar__20', $fileName);
    }

    public function test_normalize()
    {
        // File name with extension.
        $fileName = $this->fileName->normalize('file not normalized àèì.foo.bar.jpg');
        $this->assertEquals('file-not-normalized-aeifoobar.jpg', $fileName);

        // File name without extension.
        $fileName = $this->fileName->normalize('lorem ipsum dolor');
        $this->assertEquals('lorem-ipsum-dolor', $fileName);
    }

    public function test_available()
    {
        $path = './tests/_data/FileName';

        // File name with extension.
        $fileName = $this->fileName->available($path, 'test-file.txt');
        $this->assertEquals('test-file-2.txt', $fileName);

        // File name without extension.
        $fileName = $this->fileName->available($path, 'test-file');
        $this->assertEquals('test-file-2', $fileName);
    }

}
