 /*
* jQuery FormHelper plugin 1.0
*
* Copyright (c) 2010 Enbake Consulting Pvt. Ltd.
*
* Project Home : http://code.google.com/p/jqformhelper/
*
* Licensed under the MIT licenses:
* http://www.opensource.org/licenses/mit-license.phpf
*
*/

(function($){
	var FormHelper = function(element, settings) {
	   element = $(element);

	   var obj = this;
	   var options = $.extend({
		   	formid			:		null,	// The id of the form.
		   	cloneRow		:		false,	// Whether to clone some existing row for html.
		   	actionElem		:		'.action', // Which element triggers the row addition action.
	       	cloneElem		:		null,	// Which element to clone, if cloneRow is set.
	       	cloneHTML		:		null,	// if cloneRow is not set, then this html is used for new row.
	       	isParent		:		true,	// if the form container is parent of the cloneElem.
	       	wrapElem		:		'div',	// What should be the wrapper element.
	       	labelPrefix		:		'Row ', // What should be the prefix for the added row
	       	labelDiv		:		'#label',	// The div containing the label.
	       	child			:		'.formRow',	// The class of the child.
	       	canDeleteLast	:		false,	// If a user can delete the last available row.
			appendTo		:		null
	   }, settings || {});
	
	   /*
	    * appendRow
	    * 
	    * appends the row to the end of the form.
	    */
	   this.appendRow = function() {
		   if (options.cloneRow) {
				   var firstElem = $(options.cloneElem + ':first');
				   // make the new element.
				   var newElem = $(firstElem).clone();
				   var nodeCount = $(firstElem).parent().find(options.child).length;
				   
				   if (options.labelPrefix) {
				   	newElem.find(options.labelDiv).html(options.labelPrefix+nodeCount+':');
				   }
	
				   newElem.find('input, select, textarea').each(function() {
	           			var name = $(this).attr('name');
	           			var newName = name.replace(/\d+/, nodeCount);
	
	           			$(this).attr('name', newName);
	           			if ($(this).attr("type") != 'hidden')
	           				$(this).attr('value', '');
	           			
	           		});

					newElem.find('input, select, textarea, div, td, span, a').each(function() {
	           			var id = $(this).attr('id');
	           			var newId = id.replace(/\d+/, nodeCount);
	
	           			$(this).attr('id', newId);
	           			if ($(this).attr("type") != 'hidden')
	           				$(this).attr('value', '');
	           			
	           		});
					
           			if (options.isParent) {
           				newElem.appendTo($(firstElem).parent());
           			}
           			else {
						newElem.appendTo($(options.appendTo));
           				//element.closest(options.cloneElem).after($(newElem));
           			}
           }
	   };

	   /*
	    * deleteRow
	    * 
	    * deletes the specified row from the form.
	    */
	   this.deleteRow = function() {
		   var numElements = $(options.cloneElem).length;

		   if ((numElements > 1) || options.canDeleteLast) {
			   if (options.isParent) {
				   // We need to remove the parent of the element.
				   element.closest(options.cloneElem).effect('highlight', {color:'#F3E6E6', mode:'hide'}, 2000,
						   function() {
							   $(this).remove();
							   // Renumber the elements and the data.
							   $(options.cloneElem).each(function(index) {
								   $(this).find(options.labelDiv).html(options.labelPrefix+(index+1)+':');
								   
								   $(this).find('input, select, textarea, div, td, span, a').each(function() {
					           			var name = $(this).attr('name');
					           			var newName = name.replace(/\d+/, index);
					
					           			$(this).attr('name', newName);
					           		});
						});
					});
			   }
		   }
	   };
	};

    $.fn.extend({
    	FormModifier: function(options) {
            return this.each(function() {
                if ($(this).data('FormModifier')) return;

                var formModifier = new FormHelper(this, options);
                $(this).data('FormModifier', formModifier);
            });
        }
    });
})(jQuery);