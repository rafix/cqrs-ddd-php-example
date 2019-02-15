<?php

declare(strict_types = 1);

namespace CodelyTv\Test\Context\Video\Module\VideoComment\Application\Publish;

use CodelyTv\Context\Mooc\Module\VideoComment\Application\Publish\PublishVideoCommentCommandHandler;
use CodelyTv\Context\Mooc\Module\VideoComment\Application\Publish\VideoCommentPublisher;
use CodelyTv\Context\Mooc\Module\VideoComment\Domain\VideoComment;
use CodelyTv\Context\Mooc\Module\VideoComment\Domain\VideoCommentRepository;
use CodelyTv\Test\Context\Video\Module\Video\Domain\VideoIdMother;
use CodelyTv\Test\Context\Video\Module\VideoComment\Domain\VideoCommentContentMother;
use CodelyTv\Test\Context\Video\Module\VideoComment\Domain\VideoCommentIdMother;
use CodelyTv\Test\Context\Video\Module\VideoComment\Domain\VideoCommentPublishedDomainEventMother;
use CodelyTv\Test\Context\Video\Module\VideoComment\Domain\VideoCommentMother;
use CodelyTv\Test\Context\Video\VideoContextUnitTestCase;
use Mockery\MockInterface;
use function CodelyTv\Test\similarTo;

final class PublishVideoCommentTest extends VideoContextUnitTestCase
{
    private $handler;
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $publisher = new VideoCommentPublisher($this->repository(), $this->domainEventPublisher());

        $this->handler = new PublishVideoCommentCommandHandler($publisher);
    }

    /** @test */
    public function it_should_publish_a_video()
    {
        $command = PublishVideoCommentCommandMother::random();

        $id      = VideoCommentIdMother::create($command->id());
        $videoId = VideoIdMother::create($command->videoId());
        $content = VideoCommentContentMother::create($command->content());

        $comment = VideoCommentMother::create($id, $videoId, $content);

        $domainEvent = VideoCommentPublishedDomainEventMother::create($id, $videoId, $content);

        $this->shouldSaveVideoComment($comment);
        $this->shouldPublishDomainEvents($domainEvent);

        $this->dispatch($command, $this->handler);
    }

    /** @return VideoCommentRepository|MockInterface */
    private function repository()
    {
        return $this->repository = $this->repository ?: $this->mock(VideoCommentRepository::class);
    }

    private function shouldSaveVideoComment(VideoComment $comment)
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with(similarTo($comment))
            ->andReturnNull();
    }
}
