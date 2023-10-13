<?php

function getModelName(string $model)
{
    preg_match_all('/(?:^|[A-Z])[a-z]+/', $model, $matches);

    return ucfirst(implode(' ', $matches[0]));
}
