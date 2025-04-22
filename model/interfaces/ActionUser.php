<?php

interface ActionUser
{
    public function execute(UserDAO $userDAO): void;
}