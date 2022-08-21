<?php


namespace Tests\Unit\BusinessLogic\Projects;


use App\BusinessLogic\Projects\ProjectsBL;
use App\BusinessLogic\Projects\ProjectsException;
use App\DataAccess\ProjectsRepo;
use PHPUnit\Framework\TestCase;

class ProjectsBLTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function test_createProjectCanSaveProject()
    {
        $projectsRepo = $this->createMock(ProjectsRepo::class);
        $projectsRepo->method('projectExists')->willReturn(false);
        $projectsRepo->method('createProject')->willReturn(true);
        $projectBl = new ProjectsBL($projectsRepo);
        $projectBl->createProject('toaster');
    }

    public function test_createProjectThrowsOnDuplicateName()
    {
        $projectsRepo = $this->createMock(ProjectsRepo::class);
        $projectsRepo->method('projectExists')->willReturn(true);
        $projectBl = new ProjectsBL($projectsRepo);
        $this->expectException(ProjectsException::class);
        $this->expectExceptionCode(ProjectsException::DUPLICATE_PROJECT_NAME);
        $projectBl->createProject('toaster');
    }

    public function test_createProjectThrowsWhenUnableToSave()
    {
        $projectsRepo = $this->createMock(ProjectsRepo::class);
        $projectsRepo->method('projectExists')->willReturn(false);
        $projectsRepo->method('createProject')->willReturn(false);
        $projectBl = new ProjectsBL($projectsRepo);
        $this->expectException(ProjectsException::class);
        $this->expectExceptionCode(ProjectsException::CANNOT_CREATE_PROJECT);
        $projectBl->createProject('toaster');
    }

}
