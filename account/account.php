<?php 
/*
Template Name: Account
*/

if ( is_user_logged_in() != true ) header('Location: /login');

get_header();
?>


<?php
get_footer();