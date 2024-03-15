<?php
/*
Template Name: Home Page
*/
get_header();
$jobs = (new \controllers\Jobs())->getJobs();
get_footer();
