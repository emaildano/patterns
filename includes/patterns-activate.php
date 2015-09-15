<?php

add_action('init', 'patterns_flush_rewrite');
function patterns_flush_rewrite() {
    flush_rewrite_rules();
}