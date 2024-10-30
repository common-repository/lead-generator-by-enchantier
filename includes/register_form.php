<h1>Créer un compte EnChantier Lead Provider</h1>
<p>
    Afin d'utiliser Notre système de génération de lead, vous devez au préalable vous enregistrer en tant que fournisseur de lead.<br>
    Veuillez completer le formulaire ci-dessous :
</p>

<form id="EnChantier_form" method="post">
    <table class="form-table widefat">
        <tbody>
            <tr>
                <th scope="row"><div style="text-align: right;">Votre email :</div></th>
        <td>    
            <input type="email" name="email" value="<?php echo get_option('admin_email'); ?>" placeholder="mon.email@mon-domain.com" size="40" /><br />
            <span class="error email"></span>
        </td>
        </tr>
        <tr>
            <th scope="row"><div style="text-align: right;">Votre mot de passe :</div></th>
        <td>    
            <input type="text" name="mdp" id="mdp" placeholder="password, min 6 caractères" size="40" /><br />
            <span class="error mdp"></span>
        </td>
        </tr>
        <tr>
            <th scope="row"><div style="text-align: right;">Nom de domaine à autoriser :</div></th>
        <td>
            <input type="text" value="<?php echo get_option('siteurl'); ?>" placeholder="http://test-wordpress.com" name="domain" id="domain" size="40" /> Nom de domaine du site sur lequel le widget sera utilisé. <b>Attention aux "www" !</b> http://www.mon-site.com et http://mon-site.com (sans le www) sont différents !<br />
            <span class="error domain"></span>
        </td>
        </tr>
        <tr>
            <th scope="row"><div style="text-align: right;"></div></th>
        <td>    
            <label><input type="checkbox" value="1" name="validation_cgv" id="validation_cgv"> J'ai lu et j'accepte les <a target="_blank" href="admin.php?page=CGU_EnChantier">Conditions Générales d'Utilisation</a></label><br />        
            <span class="error validation_cgv"></span>
        </td>
        </tr>
        <tr>
            <th scope="row"></th>
            <td><input type="hidden" name="ENCHANTIER_KEY" id="ENCHANTIER_KEY" value="" />
                <input type="submit" value="S'inscrire au programme" class="button button-primary">
            </td>
        </tr>
        </tbody>
    </table>
</form>
<script>
    jQuery(function ($) {
        $('#EnChantier_form').bind('submit', function () {
            leave = true;
            $('#EnChantier_form .error').html('');
            data = $('#EnChantier_form').serialize();
            $.ajax({
                type: "POST",
                url: "http://api.enchantier.com/register/?api_key=<?php echo ENCHANTIER_REGISTER_KEY ?>",
                data: data,
                async: false,
                success: function (received) {
                    console.log(received);
                    if (received.result == 0) {
                        for (var index in received.error) {
                            $('.error.' + index).html(received.error[index]);
                        }
                        leave = false;
                    } else {
                        console.log('no error');
                        $('#EnChantier_form #ENCHANTIER_KEY').val(received.api_key);
                        leave = true;
                    }
                }
            });
            return leave;
        });
    });
</script>
<style>
    span.error {
        color:red;
        font-style: italic;
    }
</style>

