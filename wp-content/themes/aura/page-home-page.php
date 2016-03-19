<?php
/**
 * The template for displaying all single posts and attachments
 *
 * Template Name: Home Page
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header();

if (!is_user_logged_in()) {
  $aura_home=get_option('siteurl');
?>
<p> Please <?php wp_loginout($aura_home); ?>  </p>
<!--
<p style="text-align: left;"><a style="text-align: center;" href="http://aura.gailabs.com/wp-login.php" target="_blank">Login </a>here</p>
-->

<?php
}
get_sidebar();
get_footer();
?>

<ul class="headerlinks">
  <li><?php $aura_home = get_option('siteurl'); wp_loginout($aura_home); ?></li>
</ul>
