<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/24/15, 12:05 AM
 */

namespace Sahib\Elegan\Support;


class FileName {

    /**
     * Get an available file name.
     *
     * @param string $path
     * @param string $filename
     * @return string
     */
    public function available($path, $filename)
    {
        $count = 1;
        $availableName = $filename;

        while (file_exists("$path/$availableName")) {
            $availableName = $this->addCounter($filename, $count);
            $count++;
        }

        return $availableName;
    }

    /**
     * Normalize a filename.
     *
     * @param string $filename
     * @return string
     */
    public function normalize($filename)
    {
        // Handle files with extension.
        list($name, $extension) = $this->split($filename);

        return str_slug($name) . ($extension ? ".$extension" : '');
    }

    /**
     * Appends the count to a file name.
     *
     * @param string $filename
     * @param int $count
     * @param string $separator
     * @return string
     */
    public function addCounter($filename, $count, $separator = '-')
    {
        list($name, $extension) = $this->split($filename);

        return $name . $separator . $count . ($extension ? ".$extension" : '');
    }

    /**
     * Split a filename into a name and extension parts.
     *
     * @param string $filename
     * @return array
     */
    public function split($filename)
    {
        if (strpos($filename, '.') === false) {
            return [$filename, ''];
        }

        $parts = explode('.', $filename);
        $extension = array_pop($parts);

        $name = implode('.', $parts);

        return [$name, $extension];
    }

}
