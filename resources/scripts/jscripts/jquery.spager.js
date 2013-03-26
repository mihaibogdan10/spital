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


		var p = {by:'id', mode: 'ASC', po: '10', pg: '1'};
		var oldp = jQuery.extend(true, {}, p);;

		var controlsElement = settings.ctrls;
		var itemsPerPage = parseInt(p['po']);
		var opts = settings.opts;
		var animation = settings.animate;
		var pageName = settings.pageName;
		var other = settings.other;
		var idName = "#" + settings.idName;
		var entries;
		var ppi = 200;
		var tg;
		var rows;
		var rowCount;
		var tableHeight;
		var curPage = 1;
		var lastPage = 1;

		var globalCurrentPage;
		var globalCurrentSet = -1;
		var pagesPerSet;
		var globalLastPage = 4294967295;


		if (opts == null) {
			opts = [10, 15, 25, 50];
		}

		if (itemsPerPage == null) {
			itemsPerPage = opts[0];
		}



		jQuery.schimbaPg = function(parametri) {
			console.log(p);
			if (globalCurrentSet >= 0) $("#load_circle").show();
			if (parametri) 
				p = jQuery.extend(true, {}, parametri);
			var pg = parseInt(p.pg);
			console.log("globalCurrentPage: " + globalCurrentPage);
			console.log("globalCurrentSet: " + globalCurrentSet);

			if (opts.indexOf(parseInt(p['po'])) == -1){
				p['po'] = opts[0];
				jQuery.render();
			}
			if (p['mode'].toUpperCase() != 'ASC' && p['mode'].toUpperCase() != 'DESC'){
				p['mode'] = 'ASC';
				jQuery.render();
			}

			console.log(p);
			console.log(oldp);

			//verific daca pagina dorita exista (poate redundant, dar nu se stie niciodata)
			if (globalLastPage < pg || pg <= 0){
				console.log("eroare in spager: pagina ceruta nu exista");
				return;
			} 
			

			itemsPerPage = parseInt(p['po']);
			pagesPerSet = parseInt(parseInt(ppi) / parseInt(itemsPerPage));
			var globalSet = parseInt((parseInt(pg) - 1) / parseInt(pagesPerSet));
			var localPage = pg - (globalSet * parseInt(pagesPerSet));

			console.log("globalSet: " + globalSet + "   localPage: " + localPage);

//			if (oldp['po'] != p['po'] || oldp['by'] != p['by'] || oldp['mode'] != p['mode'] ) {
//				jQuery.loadSection(globalSet, localPage);
//				return;
//			}

			for (var key in p){
				if (oldp[key] != p[key] && key != 'pg'){
					jQuery.loadSection(globalSet, localPage);
					return;
				}
			}

			//daca pagina e din setul curent, schimb pur si simplu din javascript
			if (globalSet == globalCurrentSet) {
				jQuery.page(localPage);
//				console.log(this);
			}
			//altfel trebuie sa apelez la php
			else {
				jQuery.loadSection(globalSet, localPage);

			}

		}

		jQuery.loadSection = function(globalSet, localPage) {
			oldp = jQuery.extend(true, {}, p);

			var h = '';
			var exclude = ["by", "mode", "po", "pg"]
			for (var key in p){
				if (exclude.indexOf(key.toLowerCase()) == -1)
					h += "&" + key + '=' + p[key];
			}

			var obj = "by=" + p.by + "&mode=" + p.mode + "&inferior=" + (parseInt(ppi) * globalSet) + 
									"&ipp=" + ppi + other + h;
			console.log(obj);
			curPage=localPage;
			$("#ajax_section").load(pageName + " " + idName, obj, function(data) {
				$(data).find('#icc10n');
				jQuery.generatePages();});
		}

		jQuery.changeHash = function(key, value) {
			p[key] = value;
			jQuery.render();
		}

		jQuery.getHash = function(key) {
			return p[key];
		}

		jQuery.render = function() {
			var hs = "##";
			var h = '';
			for (var key in p){
				h += "&" + key + '=' + p[key];
			}
			hs += h.substring(1);

			window.location.hash = hs;
		}

		jQuery.nextPage = function() {
			if (globalCurrentPage == globalLastPage)
				return;
			p['pg'] = globalCurrentPage + 1;
			jQuery.render();
		}

		jQuery.prevPage = function() {
			if (globalCurrentPage <= 1)
				return;
			p['pg'] = globalCurrentPage - 1;
			jQuery.render();
		}

		jQuery.changeBy = function(by) {
			if (p['by'].toUpperCase() === by.toUpperCase()) {
				p['mode'] = (p['mode'].toUpperCase() === "ASC") ? "desc" : "asc";
			}
			else {
				p['mode'] = "asc";
			}
			p['pg'] = 1;
			p['by'] = by;
			jQuery.render();
		}

		jQuery.changeNumber = function(by) {
			p['po'] = parseInt(by);
			p['pg'] = 1;
			jQuery.render();
		}


		jQuery.globalPage = function(pg) {
			p['pg'] = pg;
			jQuery.render();
		}

		jQuery.page = function(pg) {
			$("#load_circle").hide();
			curPage = pg;
			stP = itemsPerPage * (pg - 1);
			enP = Math.min(rowCount - 1, parseInt(stP) + parseInt(itemsPerPage) - 1);


			globalCurrentPage = parseInt(p.pg);
			globalCurrentSet = parseInt((globalCurrentPage - 1) / pagesPerSet);
			globalLastPage = Math.ceil(parseInt(entries) / itemsPerPage);
			offset = parseInt(ppi) * globalCurrentSet;


			$("#" + controlsElement + " #currentlyShowing").text("Intrari afisate: " + (offset + parseInt(stP + 1)) + " - " + (offset + parseInt(enP + 1)));
			$(rows).show();
			$(rows).filter(":lt(" + stP + ")").hide();
			$(rows).filter(":gt(" + enP + ")").hide();



//			globalCurrentPage = parseInt(parseInt(offset) / itemsPerPage) + curPage;
//			globalCurrentSet = parseInt(parseInt(offset) / parseInt(ppi));
//			pagesPerSet = parseInt(parseInt(ppi) / parseInt(itemsPerPage));
//			globalLastPage = Math.ceil(parseInt(entries) / itemsPerPage);

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
			console.log(itemsPerPage);
			entries = $("#entries").text();
			if (entries <= 0) {
				$("#page_controls").hide();
			}
			console.log(entries);
			tg = $(idName);
			rows = $(tg).children().find("tr").filter(":not(:first-child)");
			rowCount = rows.size();
			console.log(tg);
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


			$("#pager").empty();
			for (i = 0; i < opts.length; i++) {
				if (i == parseInt(p['po']))
					$("#pager").append("\n<option value='" + opts[i] + "'>" + opts[i] + "</option>");
				else
					$("#pager").append("\n<option value='" + opts[i] + "'>" + opts[i] + "</option>");

			}

			var ind = 0;
			$("#pager option").each(function() {
				if (parseInt($(this).text()) == parseInt(p['po'])) {
					$(this).attr("selected", "selected");
					return;
				}
				ind++;
			});
		}



		
//		$.generatePages();

		return this;

	}

})(jQuery);