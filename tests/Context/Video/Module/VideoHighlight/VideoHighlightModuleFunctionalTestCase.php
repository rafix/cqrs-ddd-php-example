<?php

declare(strict_types = 1);

namespace CodelyTv\Test\Context\Video\Module\VideoHighlight;

use CodelyTv\Context\Mooc\Module\Video\Domain\VideoRepository;
use CodelyTv\Test\Context\Video\VideoContextFunctionalTestCase;

abstract class VideoHighlightModuleFunctionalTestCase extends VideoContextFunctionalTestCase
{
    protected function repository(): VideoRepository
    {
        return $this->service('codely.video.video_highlight.repository');
    }
}
