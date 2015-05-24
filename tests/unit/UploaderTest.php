<?php

use Sahib\Elegan\Support\FileName;
use Sahib\Elegan\Uploader\Uploader;

class UploaderTest extends \Codeception\TestCase\Test
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        Mockery::close();
    }

    public function test_movefiles_method()
    {
        // The name of the file the user want to upload.
        $filename = 'funny-cat.jpg';

        // The input to merge into the http request.
        $newRequestInput = ['image' => $filename];

        // The elegan configuration for the resource.
        $config = [
            'image' => [
                'path' => 'my/images',
            ],
        ];

        // Mock the request and the uploaded file.
        $request = Mockery::mock('\Illuminate\Http\Request');
        $file = Mockery::mock('\Symfony\Component\HttpFoundation\File\UploadedFile');

        // The uploaded file should receive the following methods calls:
        // First, to get the client original name.
        $file->shouldReceive('getClientOriginalName')->andReturn($filename)->once();
        // Second, to move the file to the destination directory.
        $file->shouldReceive('move')->with($config['image']['path'], $filename)->once();

        // The request should receive the followin methods calls:
        // to check there is a file in the request.
        $request->shouldReceive('hasFile')->andReturn(true)->once();
        // to get the uploaded file.
        $request->shouldReceive('file')->andReturn($file)->once();
        // to merge the new input into the request.
        $request->shouldReceive('merge')->with($newRequestInput)->once();

        $uploader = new Uploader(new FileName());
        $input = $uploader->moveFiles($request, $config);

        $this->assertEquals($newRequestInput, $input);
    }
}
