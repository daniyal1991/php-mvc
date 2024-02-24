<?php


namespace app\core;


abstract class Model //make this Abstract to avoid creating instance of Model class
{
    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function validate($data) {

    }
}