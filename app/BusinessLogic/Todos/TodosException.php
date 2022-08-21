<?php


namespace App\BusinessLogic\Todos;


use Exception;

class TodosException extends Exception
{
    public const CANNOT_CREATE_TODO = 1;
    public const PROJECT_ID_DOES_NOT_EXIST = 2;
    public const COULD_NOT_DELETE_TODO = 3;
}
