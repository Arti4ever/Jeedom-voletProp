<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('voletProp');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>
<div class="row row-overflow">
<div class="col-xs-12 eqLogicThumbnailDisplay">
  <legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
  <div class="eqLogicThumbnailContainer">
      <div class="cursor eqLogicAction logoPrimary" data-action="add">
        <i class="fas fa-plus-circle"></i>
        <br>
        <span>{{Ajouter}}</span>
    </div>
      <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
      <i class="fas fa-wrench"></i>
    <br>
    <span>{{Configuration}}</span>
  </div>
  </div>
  <legend><i class="fas fa-table"></i> {{Mes Volets}}</legend>
	   <input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />

		<div class="eqLogicThumbnailContainer">

			<?php
				foreach ($eqLogics as $eqLogic) {
					$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
					echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
					echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
					echo '<br>';
					echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
					echo '</div>';
				}
			?>
		</div>
	</div>
	<div class="col-xs-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-list-alt"></i> {{Commandes}}</a></li>
  		</ul>


			<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
				<div role="tabpanel" class="tab-pane active" id="eqlogictab">
					<br/>
						<form class="form-horizontal">
							<fieldset>
								<div class="form-group ">
									<label class="col-sm-3 control-label">{{Nom du volet}}</label>
									<div class="col-sm-3">
										<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
										<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom du volet}}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" >{{Objet parent}}</label>
									<div class="col-sm-3">
										<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
											<option value="">{{Aucun}}</option>
											<?php
												foreach (jeeObject::all() as $object)
													echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
								<label class="col-sm-3 control-label">{{Catégorie}}</label>
									<div class="col-sm-9">
										<?php
										foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
											echo '<label class="checkbox-inline">';
											echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
											echo '</label>';
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" >{{Etat du widget}}</label>
									<div class="col-sm-9">
										<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
										<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
									</div>
								</div>
							</fieldset>
						</form>
					<div class="col-sm-6">
						<form class="form-horizontal">
							<legend>Objet de control du volet</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Inverser le sens}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Permet d'inverser le sens, 100% = Fermé, au lieu de 100% = ouvert}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<label>{{Inverser}}</label>
										<input type="checkbox" class="eqLogicAttr" data-label-text="{{Inverser}}" data-l1key="configuration" data-l2key="Inverser" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Objet de montée}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Sélectionnez la commande correspondant à la montée du volet}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<div class="input-group">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cmdUp" placeholder="{{Sélectionnez une commande}}"/>
											<span class="input-group-btn">
												<a class="btn btn-success btn-sm listCmdAction" data-type="action">
													<i class="fas fa-list-alt"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Objet de stop}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Sélectionnez la commande correspondant au stop du volet}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<div class="input-group">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cmdStop" placeholder="{{Sélectionnez une commande}}"/>
											<span class="input-group-btn">
												<a class="btn btn-success btn-sm listCmdAction" data-type="action">
													<i class="fas fa-list-alt"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Objet de descente}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Sélectionnez la commande correspondant à la descente du volet}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<div class="input-group">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cmdDown" placeholder="{{Sélectionnez une commande}}"/>
											<span class="input-group-btn">
												<a class="btn btn-success btn-sm listCmdAction" data-type="action">
													<i class="fas fa-list-alt"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<div class="col-sm-6">
						<form class="form-horizontal">
							<legend>Objet d'état du volet</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Etat du mouvement}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Sélectionnez la commande déterminant l'état du mouvement du volet}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<div class="input-group">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cmdMoveState" placeholder="{{Sélectionnez une commande}}"/>
											<span class="input-group-btn">
												<a class="btn btn-success btn-sm listCmdAction" data-type="info">
													<i class="fas fa-list-alt"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Etat du stop}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Sélectionnez la commande déterminant l'état de l'arret du volet}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<div class="input-group">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cmdStopState" placeholder="{{Sélectionnez une commande}}"/>
											<span class="input-group-btn">
												<a class="btn btn-success btn-sm listCmdAction" data-type="info">
													<i class="fas fa-list-alt"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Fin de course}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Sélectionnez la commande déterminant la fin de course}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<div class="input-group">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="cmdEnd" placeholder="{{Sélectionnez une commande}}"/>
											<span class="input-group-btn">
												<a class="btn btn-success btn-sm listCmdAction" data-type="info">
													<i class="fas fa-list-alt"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<div class="col-sm-6">
						<form class="form-horizontal">
							<legend>Delais</legend>
							<fieldset>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Temps total}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Saisissez le temps total pour exécuter une montée ou une descente}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="Ttotal" placeholder="{{Saisir le temps total d'exécution (s)}}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Temps de décollement}}
										<sup>
											<i class="fas fa-question-circle tooltips" title="{{Saisissez le temps de décollement. Temps avant que le volet se décolle de son seuil}}"></i>
										</sup>
									</label>
									<div class="col-sm-5">
										<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="Tdecol" placeholder="{{Saisir le temps de décollement (s)}}"/>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="commandtab">
					<table id="table_cmd" class="table table-bordered table-condensed">
					    <thead>
						<tr>
						    <th>{{Nom}}</th>
						    <th>{{Paramètre}}</th>
						</tr>
					    </thead>
					    <tbody></tbody>
					</table>
				</div>
			</div>
		</div>
</div>

<?php include_file('desktop', 'voletProp', 'js', 'voletProp'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
