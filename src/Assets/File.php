<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/18/15, 10:47 PM
 */

namespace Sahib\Elegan\Assets;

class File extends \Symfony\Component\HttpFoundation\File\File
{
    /**
     * Generate a URL to an application asset.
     *
     * @param bool|null $secure
     * @return string
     */
    public function asset($secure = null)
    {
        return asset($this->getPathname(), $secure);
    }

    /**
     * Alias of asset() method.
     *
     * @return string
     */
    public function url()
    {
        return $this->asset();
    }
}
