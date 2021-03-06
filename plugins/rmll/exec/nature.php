<?php

/*
 * Plugin Rmll
 *
 */

include_spip('inc/rmll.class');

function exec_nature() {
    /* admin ou pas */
    Rmll_Helper::test_acces_admin();
    /* quelques controles ? */
    Rmll_Helper::faire_controles();
    Rmll_Helper::debut_page(_T('rmll:titre_page_gestion'));
    Rmll_Helper::debut_gauche();
    Rmll_Helper::debut_cadre_enfonce();
    Rmll_Helper::icone_horizontale(
        _T('rmll:label_liste'), 'nature', 'liste.png');
    Rmll_Helper::icone_horizontale(
        _T('rmll:label_ajout'), 'nature_edit','ajout.png');
    Rmll_Helper::fin_cadre_enfonce();
    Rmll_Helper::menu_gestion();
    Rmll_Helper::debut_droite();

    $table = new Rmll_Db('nature');

    Rmll_Helper::titre_gros(_T('rmll:label_gestion_nature'));

    /* Suppression */
    $suppr_id = Rmll_Helper::inPost('suppr_id');
    if ($suppr_id) {
        if ($table->delete($suppr_id))
            Rmll_Helper::boite_infos(_T('rmll:message_suppr_ok'));
        else
            Rmll_Helper::boite_erreurs(_T('rmll:message_suppr_err')."<br/>".$table->error());
    }

    /* affichage des données */
    $datas = $table->get_all('nom');
    if ($datas === false)
        Rmll_Helper::boite_erreurs($table->error());
    elseif (!empty($datas)) {
        Rmll_Helper::titre_moyen(_T('rmll:label_liste'));

    ?>
        <table class="rmll">
            <tr>
                <th><?php echo _T('rmll:label_nature'); ?></th>
                <th><?php echo _T('rmll:label_code'); ?></th>
                <th></th>
            </tr>
    <?php
        foreach($datas as $d) {
    ?>
            <tr>
                <td><?php echo $d['nom']; ?></td>
                <td><?php echo $d['code']; ?></td>
                <td>
            <?php
                    /* bouton d'édition */
                    Rmll_Helper::formulaire_debut(generer_url_ecrire('nature_edit'), array('class' => 'rmll_embed'));
                    Rmll_Helper::formulaire_cache('id', $d['id_nature']);
                    Rmll_Helper::formulaire_image('edit.png', '', null);
                    Rmll_Helper::formulaire_fin();

                    /* bouton de supprression */
                    Rmll_Helper::formulaire_debut(generer_url_ecrire('nature'), array('class' => 'rmll_embed'));
                    Rmll_Helper::formulaire_cache('suppr_id', $d['id_nature']);
                    Rmll_Helper::formulaire_image(
                        'suppr.png', '', array(
                            'onclick' => "javacript:return confirm('". addslashes(_T('rmll:message_suppr_confirm'))  ."');"));
                    Rmll_Helper::formulaire_fin();
            ?>
                </td>
            <?php
        }
    ?>
        </table>
    <?php
    }

    Rmll_Helper::fin_page();
}
?>