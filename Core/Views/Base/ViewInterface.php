<?php

namespace Core\Views\Base;

interface ViewInterface
{
    public function view($source, $vars = []);
}