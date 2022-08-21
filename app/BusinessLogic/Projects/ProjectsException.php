<?php


namespace App\BusinessLogic\Projects;


use Exception;

class ProjectsException extends Exception
{
    public const CANNOT_CREATE_PROJECT = 1;
    public const DUPLICATE_PROJECT_NAME = 2;
}
