/*

Author: Julijan Andjelic
Plugin name: spager
Description: simple jQuery plugin which allows you to paginate your table
             can be very useful when you want to split up large tables into
             smaller chunks
             
             
             usage:
             $("#someTable").spager({
                    
                    items:    10,
                    ctrls:    "mycontrols",
                    animate:  false,
                    opts:     [5,10,20,30,50],
                    offset:   0 
                    })
                    
          In this example we are paginating the table with id someTable into pages, each containing 10 items
          items - how many items to show on each page, default is the first opts item [optional]
          ctrls - here we are specifying our container for controls (page numbers and items per page selector)
          animate - little animation triggered upon page switch, by default it's true but you can set it to false [optional]
          opts - user can pick from these options, default is 10, 15, 25 and 50 [optional]

*/



(function($) {

	jQuery.fn.spager = function(settings) {

		var controlsElement = settings.ctrls;
		var itemsPerPage = settings.items;
		var opts = settings.opts;
		var animation = settings.animate;
		var offset = settings.offset;
		var pageName = settings.pageName;
		var entries = settings.entries;
		var ppi = settings.ipp;
		var isLast = settings.isLast;
		var tg = $(this);
		var rows = $(tg).children().find("tr").filter(":not(:first-child)");
		var rowCount = rows.size();
		var tableHeight;
		var curPage = settings.startPage;
		var lastPage = 1;

		var globalCurrentPage;
		var globalCurrentSet;
		var pagesPerSet;
		var globalLastPage;

		if (opts == null) {
			opts = [10, 15, 25, 50];
		}

		if (itemsPerPage == null) {
			itemsPerPage = opts[0];
		}

		jQuery.nextPage = function() {
			console.log (curPage, lastPage);
			if (curPage < lastPage) jQuery.page(curPage + 1);
			else if (isLast == 0) {
				/*fa o interogare pentru noul set de 500 de intrari*/
				window.location.href = pageName + "inferior=" + (parseInt(offset) + parseInt(ppi));
			}
		}

		jQuery.prevPage = function() {
			if (curPage > 1) jQuery.page(curPage - 1);
			else if (offset > 0) {
				/*fa o interogare pentru setul anterior*/
				window.location.href = pageName + "inferior=" + (parseInt(offset) - parseInt(ppi)) + "&pg=" + (parseInt(ppi) / parseInt(itemsPerPage));
			}
		}

		jQuery.globalPage = function(pg) {
			console.log("globalCurrentPage: " + globalCurrentPage);
			console.log("globalCurrentSet: " + globalCurrentSet);

			//verific daca pagina dorita exista (poate redundant, dar nu se stie niciodata)
			if (globalLastPage < pg || pg <= 0){
				console.log("eroare in spager: pagina ceruta nu exista");
				return;
			} 
			
			//caut setul din care apartine pagina dorita
			var globalSet = parseInt((parseInt(pg) - 1) / parseInt(pagesPerSet));
			//caut a cata pagina din setul respectiv este
			var localPage = pg - (globalSet * parseInt(pagesPerSet));

			console.log("globalSet: " + globalSet + "   localPage: " + localPage);

			//daca pagina e din setul curent, schimb pur si simplu din javascript
			if (globalSet == globalCurrentSet) {
				jQuery.page(localPage);
			}
			//altfel trebuie sa apelez la php
			else {
				window.location.href = pageName + "inferior=" + (parseInt(ppi) * globalSet) + "&pg=" + localPage;
			}


		}

		jQuery.page = function(pg) {
			curPage = pg;
			stP = itemsPerPage * (pg - 1);
			enP = Math.min(rowCount - 1, parseInt(stP) + parseInt(itemsPerPage) - 1);


			$("#" + controlsElement + " #currentlyShowing").text("Intrari afisate: " + (offset + parseInt(stP + 1)) + " - " + (offset + parseInt(enP + 1)));
			$(rows).show();
			$(rows).filter(":lt(" + stP + ")").hide();
			$(rows).filter(":gt(" + enP + ")").hide();

			if (animation != false) {
				$(tg).animate({
					height: 2,
					duration: 500
				})
			}

			globalCurrentPage = parseInt(parseInt(offset) / itemsPerPage) + curPage;
			globalCurrentSet = parseInt(parseInt(offset) / parseInt(ppi));
			pagesPerSet = parseInt(parseInt(ppi) / parseInt(itemsPerPage));
			globalLastPage = Math.ceil(parseInt(entries) / itemsPerPage);

			$("#pages_click").empty();
			if (globalCurrentPage > 3) {
				//$("#pages_click").append("<span class='hand' onclick='$.globalPage($(this).text());'>" +1+ "</span> ... ");
				$("#pages_click").append('<div class="button left" onclick="$.globalPage($(this).text());">' + 1 + '</div><div class="button left" style="cursor: auto;">...</div>');
			}
			for (var i = Math.max(globalCurrentPage - 2, 1); i <= Math.min(globalCurrentPage + 2, globalLastPage); i++){
				if (i == globalCurrentPage) {
					//$("#pages_click").append("<span class='hand' style='font-weight:bold; color:red;'>" +i+ "</span> ");
					$("#pages_click").append('<div class="button active left">' + i + '</div>');
				}
				else {
					//$("#pages_click").append("<span class='hand' onclick='$.globalPage($(this).text());'>" +i+ "</span> ");
					$("#pages_click").append('<div class="button left" onclick="$.globalPage($(this).text());">' + i + '</div>');
				}
			}
			if (globalCurrentPage < globalLastPage - 2) {
				//$("#pages_click").append("... <span class='hand' onclick='$.globalPage($(this).text());'>" +globalLastPage+ "</span>");
				$("#pages_click").append('<div class="button left" style="cursor: auto;">...</div><div class="button left" onclick="$.globalPage($(this).text());">' + globalLastPage + '</div>');
			}

		}

		jQuery.generatePages = function(max) {
			var page = 0;
			if (max != null) {
				parseInt(itemsPerPage = max);
			}
			i = 0;
			while (i < rowCount) {
				i += itemsPerPage;
				page++;
			}
			lastPageProducts = rowCount - (page * itemsPerPage);
			lastPage = page;
			if (lastPageProducts > 0) {
				page++;
				lastPage = page;
			}

			$("#" + controlsElement + "#pages a:eq(0)").addClass("action");
			$.page(curPage);
		}

		for (i = 0; i < opts.length; i++) {

			$("#pager").append("\n<option value='" + opts[i] + "'>" + opts[i] + "</option>");

		}


		var ind = 0;
		$("#pager option").each(function() {
			if ($(this).text() == itemsPerPage) {
				$(this).attr("selected", "true");
				return;
			}
			ind++;
		})

		$.generatePages();

		return this;

	}

})(jQuery);