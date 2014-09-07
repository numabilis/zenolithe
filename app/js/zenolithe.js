//function showSubPages(groupId, level) {
//	console.log('Open '+groupId+' ('+level+')');
//	el = $("#page-"+groupId);
//	el.load('/fr/admin/pages/list-sub.php', 'groupId='+groupId+'&level='+level);
//}

function pageAdd(parentGroup) {
	document.forms['pageTypeChooser'].elements['parentGroup'].value = parentGroup;
	$("#pageTypeChooser").dialog({title: 'Ajout d\'une page',
		buttons: [{text: "Ajouter", click: function(){document.forms['pageTypeChooser'].submit();}},
		          {text: "Annuler", click: function(){$(this).dialog("close"); }}],
		modal: true});
}

function componentAdd(zone) {
	document.forms['componentChooser'].elements['zoneName'].value = zone;
	$("#componentChooser").dialog({title: 'Ajout d\'un composant',
		buttons: [{text: "Ajouter", click: function(){document.forms['componentChooser'].submit();}},
		          {text: "Annuler", click: function(){$(this).dialog("close"); }}],
		modal: true});
}

function componentRemove(zone, id, order) {
	document.forms['componentRemover'].elements['zoneName'].value = zone;
	document.forms['componentRemover'].elements['componentId'].value = id;
	document.forms['componentRemover'].elements['componentOrder'].value = order;
	$("#componentRemover").dialog({title: 'Confirmation',
		buttons: [{text: "Oui", click: function(){document.forms['componentRemover'].submit();}},
		          {text: "Non", click: function(){$(this).dialog("close"); }}],
		modal: true});
}

function componentMove(zone, id, order, action) {
	document.forms['componentMover'].elements['zoneName'].value = zone;
	document.forms['componentMover'].elements['componentId'].value = id;
	document.forms['componentMover'].elements['componentOrder'].value = order;
	document.forms['componentMover'].elements['action'].value = action;
	document.forms['componentMover'].submit();
}

function componentExchange(zone, id, order) {
	document.forms['componentExchanger'].elements['zoneName'].value = zone;
	document.forms['componentExchanger'].elements['componentId'].value = id;
	document.forms['componentExchanger'].elements['componentOrder'].value = order;
	$("#componentExchanger").dialog({title: 'Ajout d\'un composant',
		buttons: [{text: "Echanger", click: function(){document.forms['componentExchanger'].submit();}},
		          {text: "Annuler", click: function(){$(this).dialog("close"); }}],
		modal: true});
}

function menuAdd(parentGroup) {
	document.forms['menuAdder'].elements['parentGroup'].value = parentGroup;
	$("#menuAdder").dialog({title: 'Ajout d\'une entrée de menu',
		buttons: [{text: "Ajouter", click: function(){document.forms['menuAdder'].submit();}},
		          {text: "Annuler", click: function(){$(this).dialog("close"); }}],
		modal: true});
}

function passwordRetrieve(pw1, pw2, pwf) {
	correct = true;
	
	if($('#'+pw1).val() == '') {
		alert('Le mot de passe ne peut être vide !');
		correct = false;
	} else if(($('#'+pw1).val() != $('#'+pw2).val())) {
		alert('Les mots de passe sont différents !');
		correct = false;
	} else {
		$('#'+pwf).val(MD5($('#'+pw1).val()));
	}
	
	return correct;
}

$.timepicker.regional['fr'] = {
		closeText: 'Ok',
		prevText: '< Précédent',
		nextText: 'Suivant >',
		currentText: 'Maintenant',
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin', 'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
		monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun', 'Jui','Aou','Sep','Oct','Nov','Déc'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Не',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		timeOnlyTitle: 'Choix de l\'heure',
		timeText: 'Heure',
		hourText: 'Heure',
		minuteText: 'Minute',
		secondText: 'Seconde',
		millisecText: 'Milliseconde',
		timezoneText: 'Fuseau horaire'

	};
$.timepicker.setDefaults($.timepicker.regional['fr']);

$(document).ready(function() {
    $(".wysiwyg").cleditor({
        width:        780, // width not including margins, borders or padding
        height:       400});
    $(".button").button();
    $(".tabs").tabs();
  });

