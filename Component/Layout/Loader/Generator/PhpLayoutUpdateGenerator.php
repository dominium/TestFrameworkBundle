<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\Loader\Generator;

class PhpLayoutUpdateGenerator extends AbstractLayoutUpdateGenerator
{
    /**
     * {@inheritdoc}
     */
    protected function doGenerateBody(GeneratorData $data)
    {
        return trim(str_replace(['<?php', '<?', '?>'], '', $data->getSource()));
    }
}
