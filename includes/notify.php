<?php

/* Display a notice that can be dismissed */


function EnChantier_admin_notice() {
	global $current_user ;global $pagenow;

        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'EnChantier_ignore_notice') && $pagenow !== 'admin.php') {
        echo '<div class="updated"><p>'; 
        printf(__('<p><b>Votre générateur de lead EnChantier est installé, <a href="admin.php?page=EnChantier">inscrivez-vous</a> pour commencer à encaisser vos revenus ! </p>'
                . '<p><a href="admin.php?page=EnChantier">S\'enregistrer au programme</a> | <a href="%1$s">Cacher ce message</a></p>'), '?EnChantier_nag_ignore=0');
        echo "</p></div>";
	}
}


function EnChantier_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['EnChantier_nag_ignore']) && '0' == $_GET['EnChantier_nag_ignore'] ) {
             add_user_meta($user_id, 'EnChantier_ignore_notice', 'true', true);
	}
}