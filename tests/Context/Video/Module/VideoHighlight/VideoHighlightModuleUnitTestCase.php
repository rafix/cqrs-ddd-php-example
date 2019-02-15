<?php

declare(strict_types = 1);

namespace CodelyTv\Test\Context\Video\Module\VideoHighlight;

use CodelyTv\Context\Mooc\Module\VideoHighlight\Domain\VideoHighlightRepository;
use CodelyTv\Test\Context\Video\VideoContextUnitTestCase;
use Mockery\MockInterface;

abstract class VideoHighlightModuleUnitTestCase extends VideoContextUnitTestCase
{
    private $repository;

    /** @return VideoHighlightRepository|MockInterface */
    protected function repository()
    {
        return $this->repository = $this->repository ?: $this->mock(VideoHighlightRepository::class);
    }
}
