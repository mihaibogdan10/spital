    
    var table = $('#records');

    $('th')
        .wrapInner('<span title="sort this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    if (thIndex == 0)
                        return parseInt($.text([a]), 10) > parseInt($.text([b]),10) ?
                            inverse ? -1 : 1
                            : inverse ? 1 : -1;

                    if (thIndex == 3) {
                        var date1 = $.text([a]).split(/[\s,.:]+/);
                        var date2 = $.text([b]).split(/[\s,.:]+/);
                        var y1 = date1[2];
                        var y2 = date2[2];
                        var m1 = date1[1];
                        var m2 = date2[1];
                        var d1 = date1[0];
                        var d2 = date2[0];
                        var h1 = date1[3];
                        var h2 = date2[3];
                        var min1 = date1[4];
                        var min2 = date2[4];
                        var s1 = date1[5];
                        var s2 = date2[5];
                        var textDate1 = "" + y1+m1+d1+h1+min1+s1;
                        var textDate2 = "" + y2+m2+d2+h2+min2+s2;

                        return textDate1 > textDate2 ?
                            inverse ? -1 : 1
                            : inverse ? 1 : -1;
                    }

                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
                
        });
