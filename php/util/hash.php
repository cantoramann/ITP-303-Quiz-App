<?php

function hashPassword($password)
{
    return hash("sha256", $password);
}
