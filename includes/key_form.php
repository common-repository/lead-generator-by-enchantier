<h1>Gestion des domaines et sous domaines <small>Lead Generator EnChantier</small></h1>
<p>Cette page vous permet d'ajouter les différents domaines sur lesquels vous souhaitez afficher votre widget.</p>
<p>Notez que www.domain.com ce n'est pas la même chose que domain.com. Si votre site web s'affiche aussi bien avec ou sans les www (sans redirection automatique), enregistrez ici ces deux domaines : www.domain.com et domain.com. </p>
<p>Nous affichons ici vos clés d'activations pour chaque domaine, mais vous n'avez pas besoin de modifier le code de votre widget domaine par domaine, cela se fait automatiquement.</p>
<p>Note : n'enregistrez pas plus d'une clé pour 1 même domaine, votre widget connaitrait des dysfonctionnements.</p>

<form method="post">
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr><th>Domaine</th><th>Clé</th></tr>
        </thead>
        <tbody><?php
            require CD_PLUGIN_PATH . 'includes/api.client.inc.php';
            $api = new apiEnchantier();
            if (isset($_POST['new_domain'])) {
                $new_domain = sanitize_trackback_urls($_POST['new_domain']);
                if (!filter_var($new_domain, FILTER_VALIDATE_URL) === false) {
                    $url = "http://api.enchantier.com/addKey/?api_key=BFB423BB8E83D493A5ECCB2728885";
                    $data = array(
                        'key' => ENCHANTIER_KEY,
                        'new_domain' => $new_domain
                    );
                    // send data
                    $api->send($url, $data, "POST");
                } 
            }
            $url = "http://api.enchantier.com/keyList/?api_key=BFB423BB8E83D493A5ECCB2728885";

            $data = array(
                'key' => ENCHANTIER_KEY
            );
            // send data
            $api->send($url, $data, "POST");


            if (isset($api->decoded->response->status) && $api->decoded->response->status == 'ERROR') {
                die('error occured: ' . $api->decoded->response->errormessage);
            }
            $this->options = array();
            foreach ($api->decoded as $value) {
                echo "<tr><td><input type='text' class='regular-text' disabled value='http(s)://" . $value->domain
                . "'></td><td>" . $value->key
                . "</td></tr>";
                $this->options[$value->domain] = $value->key;
            }
            $this->save_options();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td><input id="new_domain" class="regular-text" type="text" name="new_domain" value="<?php echo get_option('siteurl'); ?>" placeholder="http://test-wordpress.com" /></td>
                <td>
                    <input type="submit" value="Ajouter" class="button button-primary"></td>
            </tr>
        </tfoot>
    </table>
</form>


