<?php
/**
 * The header for our theme
 * @package default
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="ltr">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="mDWCkGFF_0HPMDyfscQWTXzrIA-M12xXQEvIOF_agp4" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <?php wp_head(); ?>

</head>

<body <?php body_class('default'); ?>>

    <?php
    /**
     * header_parts hook
     */
    do_action('header_parts');
    ?>
    <!-- BODY -->
    <main class="content">
