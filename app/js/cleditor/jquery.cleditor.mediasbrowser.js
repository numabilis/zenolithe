(function($) {
  $.cleditor.buttons.mediasbrowser = {
    name: "mediasbrowser",
    image: "photo.png",
    title: "Insert a media",
    command: "inserthtml",
    popupName: "mediasbrowser",
    popupClass: "mediasbrowser",
   	buttonClick: mediasbrowserClick
  };
 
  // Add the button to the default controls before the bold button
  $.cleditor.defaultOptions.controls = $.cleditor.defaultOptions.controls
    .replace("image", "image mediasbrowser");
 
  // Handle the hello button click event
  function mediasbrowserClick(e, data) {
	  var elfinder = $("#elfinder").elfinder({
		  url: cleditorUrl,
		  lang: "fr",
	  }).dialog({
		  title: 'Insert a media',
		  buttons: [{
			  id: "insertMedia",
			  text: "Insérer",
			  click: function(){
				  files = elfinder.selected();
				  if(files.length >= 1) {
					  fileHash = files[0];
					  file = elfinder.file(fileHash);
					  if(file.mime.indexOf('image') >= 0) {
						  $('#imageEdit').dialog({
							  title: 'Meta',
							  buttons: [{
								  text: "OK",
								  click: function() {
									  alt = $('#imageEditAlt').val();
									  width = $('#imageEditWidth').val();
									  height = $('#imageEditHeight').val();
									  imageClass = $('#imageEditClass').val();
									  var html = '<img src="'+elfinder.url(fileHash)+'"';
									  if(alt != "") {
										  html = html + ' alt="' + alt +'"';
									  }
									  if(width != '') {
										  html = html + ' width="'+width+'"';
									  }
									  if(height != '') {
										  html = html + ' height="'+height+'"';
									  }
									  if(imageClass != '') {
										  html = html + ' class="'+imageClass+'"';
									  }
									  html = html + ' />';
									  var editor = data.editor;
									  editor.execCommand(data.command, html, null, data.button);
									  editor.hidePopups();
									  editor.focus();
									  $(this).dialog("close");
								  }
							  }],
							  modal: true
						  	}
						  );
					  } else {
						  var html = '<a href="'+ elfinder.url(fileHash) +'">'+ elfinder.url(fileHash) + '</a>';
						  var editor = data.editor;
						  editor.execCommand(data.command, html, null, data.button);
						  editor.hidePopups();
						  editor.focus();
						  $(this).dialog("close");
					  }
					  $(this).dialog("close");
				  }
			  },
			  disabled: true
		    },
			{text: "Annuler", click: function(){$(this).dialog("close"); }}],
		  modal: true,
		  width: 800,
		  height: 580,
		  resizable: false
		 }).elfinder('instance');
	  elfinder.bind('select', function(event) {
		  if(event.data.selected.length) {
			  $("#insertMedia").removeAttr("disabled").removeClass( 'ui-state-disabled' );
		  } else {
			  $("#insertMedia").attr("disabled", true).addClass('ui-state-disabled');
		  }
      });
  }
})(jQuery);

$(document).ready(function() {
	$('body').append('<div id="imageEdit" class="popup"><div class="content"><form><label for="alt">alt :</label> <input type="text" id="imageEditAlt"><br /><label for="width">width :</label> <input type="text" id="imageEditWidth"><br /><label for="height">height :</label> <input type="text" id="imageEditHeight"><br /><label for="class">class :</label> <input type="text" id="imageEditClass"><br /></form></div></div>');
    $('#elfinder').elfinder({
      url : cleditorUrl  // connector URL (REQUIRED)
      , lang: 'fr'                    // language (OPTIONAL)
    });
  });
