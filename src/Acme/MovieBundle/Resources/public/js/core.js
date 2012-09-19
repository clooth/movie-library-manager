// Movie library main javascript file
$(function() {

	// Movie editing
	if ($('form.movie-form').length > 0) {
		var movieId = $('form.movie-form').data('movieid');

		$.each(['genre', 'director', 'tag'], function(i, entity) {
			var entityInput  = $('#movie_'+entity+'s'),
				entityTokens = entityInput.val();

			entityInput.tokenInput("/ajax_"+entity, {
				theme: "facebook",
				preventDuplicates: true,
				// Create non-existing values
				onAdd: function(item) {
					// Only do so for items without real IDs
					if (!item.id) {
						var itemName = item.name.replace('Create: ', ''),
							entityCreateURL = entity + '_create',
							formData = {};

						formData[entity + '[name]'] = itemName;

						$.post(Routing.generate(entityCreateURL), formData, function(data) {
							entityInput.tokenInput("remove", {name: item.name});
							entityInput.tokenInput("add", JSON.parse(data));
						});
					}
				},
				tokenFormatter: function(item) {
					return "<li><p>"+ item.name.replace('Create: ', '') +"</p></li>";
				},
				allowNewValues: true
			});

			var tokens = JSON.parse(entityTokens);
			var tokenCount = tokens.length;
			for (var i = 0; i < tokenCount; i++) {
				var token = tokens[i];
				entityInput.tokenInput('add', token);
			}
		});

		function addLinkFormDeleteLink($linkFormLi) {
		    var $removeFormA = $('<a href="#" class="btn btn-danger btn-mini"><i class="icon-remove"></i></a>');
		    $linkFormLi.append($removeFormA);

		    $removeFormA.on('click', function(e) {
		        e.preventDefault();
		        $linkFormLi.remove();
		    });
		}

		function addLinkForm(collectionHolder, $newLinkLi) {
		    var newPrototype = '<div id="movie_links___name__"><div class="input-prepend"><span class="add-on">Title:</span><input type="text" id="movie_links___name___title" name="movie[links][__name__][title]" required="required" maxlength="255" class="input-small" /></div> <div class="input-prepend"><span class="add-on">URL:</span><input type="text" id="movie_links___name___url" name="movie[links][__name__][url]" required="required" maxlength="255" class="input-medium" /></div></div>';
		    var newForm = newPrototype.replace(/__name__/g, collectionHolder.children().length);
		    var $newFormLi = $('<li></li>').append(newForm);
		    $newLinkLi.before($newFormLi);
		    addLinkFormDeleteLink($newFormLi);
		}

		var collectionHolder = $('ul.links');

		collectionHolder.find('li').each(function() {
	        addLinkFormDeleteLink($(this).find('div').first());
	    });

		var $addLink = $('<a href="#" class="add_link btn btn-success btn-small"><i class="icon-plus"></i> Add a link</a>');
		var $newLinkLi = $('<li></li>').append($addLink);

	    collectionHolder.append($newLinkLi);

	    $addLink.on('click', function(e) {
	        e.preventDefault();

	        addLinkForm(collectionHolder, $newLinkLi);
	    });

	}

	// Fix mini buttons
	$('.btn-mini:has(i)').css('font-size', '13px');

});