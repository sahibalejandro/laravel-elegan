<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/18/15, 10:44 PM
 */

namespace Sahib\Elegan\Traits;

use Sahib\Elegan\Assets\File;

trait Assets
{

    /**
     * @param string $attribute
     * @return \Sahib\Elegan\Assets\File
     */
    public function asset($attribute)
    {
        $configKey = snake_case(class_basename($this));

        $config = config("elegan.$configKey");

        // TODO: Instantiate the asset type based on the configuration.
        return new File(array_get($config, "$attribute.path") . '/' . $this->$attribute);
    }

}
