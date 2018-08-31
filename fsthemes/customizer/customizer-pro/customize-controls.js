( function( api ) {

	// Extends our custom "fsmag" section.
	api.sectionConstructor['fsmag'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
