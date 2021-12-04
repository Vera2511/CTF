<?php 
function includeTemplate($templatePath, $data = [])
{
    extract($data);
    include '/var/www/ctf/templates/' . ltrim($templatePath, '/');
}