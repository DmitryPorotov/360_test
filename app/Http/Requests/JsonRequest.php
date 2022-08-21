<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class JsonRequest extends FormRequest
{
    public function validationData()
    {
        return parent::json()->all();
    }
}
