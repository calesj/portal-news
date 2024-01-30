<?php


/** format news tags */
function formatTags(array $tags): string
{
    return implode(',', $tags);
}
