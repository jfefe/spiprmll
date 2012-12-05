<?php

/*
 * Plugin Rmll
 *
 */

include_spip('inc/rmll.class');

function exec_jour() {

	/* admin ou pas */
	Rmll_Helper::test_acces_admin();
	
	/* quelques controles ? */
	Rmll_Helper::faire_controles();
	
	debut_page(_T('rmll:titre_page_gestion'));
	
	debut_gauche();
	
	debut_cadre_enfonce();
	icone_horizontale(_T('rmll:label_liste'),
			generer_url_ecrire("jour"), null, 
			_DIR_PLUGIN_RMLL.'/img_pack/liste.png');
	icone_horizontale(_T('rmll:label_ajout'),
			generer_url_ecrire("jour_edit"), null, 
			_DIR_PLUGIN_RMLL.'/img_pack/ajout.png');
	fin_cadre_enfonce();
	
	Rmll_Helper::menu_gestion();
	
	debut_droite();
	$table = new Rmll_Db('jour');
	
	Rmll_Helper::titre_gros(_T('rmll:label_gestion_jour'));    
	
	/* Suppression */
	$suppr_id = Rmll_Helper::inPost('suppr_id');
	if ($suppr_id) {
		if ($table->delete($suppr_id))
			Rmll_Helper::boite_infos(_T('rmll:message_suppr_ok'));
		else
			Rmll_Helper::boite_erreurs(_T('rmll:message_suppr_err')."<br/>".$table->error());
	}
	
	/* affichage des données */
	$datas = $table->get_all();
	if ($datas === false)
		Rmll_Helper::boite_erreurs($table->error());
	elseif (!empty($datas)) {
		Rmll_Helper::titre_moyen(_T('rmll:label_liste'));

	?>
		<table class="rmll">
			<tr>
				<th><?php echo _T('rmll:label_jour'); ?></th>
				<th></th>
			</tr>
	<?php
		foreach($datas as $d) {
	?>
			<tr>
				<td><?php echo Rmll_Helper::date_en_texte($d['date']); ?></td>
				<td>
			<?php
					/* bouton d'édition */
					Rmll_Helper::formulaire_debut(generer_url_ecrire('jour_edit'), array('class' => 'rmll_embed'));
					Rmll_Helper::formulaire_cache('id', $d['id_jour']);
					Rmll_Helper::formulaire_image('edit.png', '', null);
					Rmll_Helper::formulaire_fin();
			
					/* bouton de supprression */
					Rmll_Helper::formulaire_debut(generer_url_ecrire('jour'), array('class' => 'rmll_embed'));
					Rmll_Helper::formulaire_cache('suppr_id', $d['id_jour']);
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

	echo fin_page();
}
?>