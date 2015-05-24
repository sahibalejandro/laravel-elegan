<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/19/15, 11:18 PM
 */

namespace Sahib\Elegan\Uploader;

use Illuminate\Http\Request;
use Sahib\Elegan\Support\FileName;

class Uploader
{

    /**
     * @var \Sahib\Elegan\Support\FileName
     */
    private $fileName;

    public function __construct(FileName $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Move uploaded files to the directories defined in the configuration and updated the request
     * with the new input. Returns the added new input.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $config
     * @return array
     */
    public function moveFiles(Request $request, array $config)
    {
        $input = [];

        // Iterate over all attributes defined in the configuration, searching for a "<attribute>_file" key
        // in the request, these will be the uploaded files, then move each one to their specific
        // directory and update the current request with the uploaded files names.
        foreach (array_keys($config) as $attribute) {
            $key = "{$attribute}_file";
            $path = array_get($config, $attribute . '.path');
            $overwrite = array_get($config, $attribute . '.overwrite', false);

            if ($request->hasFile($key)) {
                $filename = $this->move($request->file($key), $path, $overwrite);
                $input[$attribute] = $filename;
            }
        }

        // Update the request object with the new input.
        $request->merge($input);

        return $input;
    }

    /**
     * Move an uploaded file to the destination directory and returns the name of the moved file.
     * All file names will be normalized.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile|array $file
     * @param string $path
     * @param bool $overwrite
     * @return string|array
     */
    private function move($file, $path, $overwrite = false)
    {
        if (is_array($file)) {
            //TODO: Handle multiple upload.
            $file = $file[0];
        }

        $filename = $this->fileName->normalize($file->getClientOriginalName());

        if (!$overwrite) {
            $filename = $this->fileName->available($path, $filename);
        }

        $file->move($path, $filename);

        return $filename;
    }
}
