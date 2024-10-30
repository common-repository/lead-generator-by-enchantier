<style>
    input[type="radio"]:checked+label>img{ border:1px solid red; }  
    .form_list optgroup {
        background-color: #ccc;
        margin-top: 15px;
        text-align: center;
        padding: 2px ; 
    }    
    .form_list optgroup * {
        background-color: #fff;
        text-align: left;
    }
</style>
<h1>Réglages fins <small>Lead Generator EnChantier</small></h1>
<p>Le tableau ci-dessous vous permet de paramétrer le widget « demande de devis » pour qu’il s’ouvre par défaut sur un formulaire donné, selon la page où il est affiché.</p>
<p>Par exemple : la page parle de parquet, j'associe son url au formulaire « Parquet (504) »</p>
<p>Note : ceci ne permet pas d’afficher ou non le widget sur les pages, seulement d'en choisir la page d'accueil</p>
<form method="post"  autocomplete="off">
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr><th width='33%'>Pages web</th><th>Formulaire par défaut associé</th></tr>
        </thead>
        <tbody><?php
            $posts = new WP_Query('post_type=any&posts_per_page=-1&post_status=publish');
            $posts = $posts->posts;
            $json = new json_enchantier();
            $assoc = (isset($_POST['assoc'])) ? $_POST['assoc'] : false;
            if (is_array($assoc)) { // sauvegarde
                $json->clear_form();
                foreach ($assoc as $value) {
                    $safe_formid = intval($value["form"]);
                    if ($safe_formid != 0 && (!filter_var($value["url"], FILTER_VALIDATE_URL) === false)) {
                        $json->add_form($safe_formid, $value["url"]);
                    }
                }
                $json->save_form();
            }

            foreach ($posts as &$post) {
                switch ($post->post_type) {
                    case 'revision':
                    case 'nav_menu_item':
                        break;
                    case 'page':
                        $post->permalink = get_page_link($post->ID);
                        break;
                    case 'post':
                        $post->permalink = get_permalink($post->ID);
                        break;
                    case 'attachment':
                        $post->permalink = get_attachment_link($post->ID);
                        break;
                    default:
                        $post->permalink = get_post_permalink($post->ID);
                        break;
                }
            }
            $i = 0;
            foreach ($posts as &$post) {
                echo "<tr>"
                . "<td width='33%'><input type='hidden' value='$post->permalink' name='assoc[$i][url]'>"
                . "<a href='$post->permalink' target='_blank'>{$post->post_title}</a> ($post->post_type)<br><small>$post->permalink</small></td>"
                . "<td>" . $json->list_html("assoc[$i][form]", $post->permalink) . "</td></tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr><th colspan="2"><h2>Choisissez ci-dessous le type d’affichage pour le widget « Demande de devis » : avec la mention « En partenariat avec Enchantier.com » (+ la zone d’arguments) ou sans cette mention (marque blanche).</h2></th></tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="radio" value="false" name="noheader" id="noheader1" <?php echo (ENCHANTIER_NOHEADER == "false") ? 'checked' : ''; ?> />
                    <label for="noheader1"><img src="<?php echo CD_PLUGIN_URL ?>img/4.exemple-widget-partenaire.png" style="max-width:100%" />
                    </label>
                </td>
                <td>
                    <input type="radio" value="true" name="noheader" id="noheader2"  <?php echo (ENCHANTIER_NOHEADER == "true") ? 'checked' : ''; ?> />
                    <label for="noheader2"><img src="<?php echo CD_PLUGIN_URL ?>img/5.exemple-widget-marque-blanche.png" style="max-width:100%" />
                    </label>
                </td>
                <td>

                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value=" Enregistrer " class="button button-primary"></td>
            </tr>
        </tfoot>
    </table>
</form>