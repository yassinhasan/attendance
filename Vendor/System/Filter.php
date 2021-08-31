<?php
namespace System;
trait Filter 
{
    public function filterSTR($value)
    {
        return filter_var($value,FILTER_SANITIZE_STRING);
    }
    public function filterInt($value)
    {
        return filter_var($value,FILTER_SANITIZE_NUMBER_INT);
    }
}