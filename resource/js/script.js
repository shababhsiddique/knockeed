function clickHandler() {

    //Do this when link clicked-
    var url = $(this).attr("href");   //Get link
    koController(url);   //Request JSon

    return false;   //Dont reload
}

function hash(s) {
    return s.split("").reduce(function(a, b) {
        a = ((a << 5) - a) + b.charCodeAt(0);
        return a & a
    }, 0);
}

function koController(url) {

    var vModHash = vMod;

    $.ajax({
        type: "POST",
        url: url,
        data: vMod.hash,
        dataType: "json",
        success: function(json) {
            //Change URL
            window.history.pushState({state: 'new'}, json.page_header, url);

            // Now use this data to update your view models, 
            // and Knockout will update your UI automatically 

            // Update view model properties and corresponding hashes
            for (var prop in json) {

                if (prop === 'content_multi') {

                    console.log("Working on " + prop);
                    var idstokeep = [];
                    var idstodelete = [];

                    console.log(json["__content_multi"]);
                    if (json["__content_multi"].length < 1) {
                        console.log("No multi here");
                        vMod.view.content_multi.removeAll();
                    } else {
                        var hashJson = JSON.parse(json["__content_multi"]);
                        vMod.hash["__content_multi"](json["__content_multi"]);
                        delete json["__content_multi"];

                        for (var MCHashItemKey in hashJson) {
                            idstokeep.push(MCHashItemKey); //These things are going to stay on the view or get updated.
                        }

                        for (var i = 0; i < vMod.view.content_multi().length; i++) {
                            var thisKey = vMod.view.content_multi()[i].key;
                            if (idstokeep.indexOf(thisKey) === -1) {
                                //This does not belong here,
                                idstodelete.push(thisKey);
                            }
                        }

                        for (var i = 0; i < idstodelete.length; i++) {
                            vMod.view.content_multi.remove(function(item) {
                                return item.key === idstodelete[i]
                            });
                        }

                        for (var MCItemKey in json["content_multi"]) {
                            //Add new arrived items
                            vMod.view.content_multi.push(new MC_Model(MCItemKey, 'dfltTmpl', {content: json["content_multi"][MCItemKey]}));
                        }
                    }

                } else {

                    console.log("Working on " + prop);

                    //Regular case
                    if (prop[1] == '_') {
                        vMod.hash[prop](json[prop]);
                    } else {
                        vMod.view[prop](json[prop]);  //vMod.view.footer(json.footer);
                    }
                }

            }

            rebind();
        }
    });

}

function rebind() {
    $("a.ko_link").unbind("click");
    $("a.ko_link").bind("click", clickHandler);
    
}

$(document).ready(function() {
    rebind();
    
    window.onpopstate = function(event) {
        location.reload();              //Back button ajax not yet implemented, will reload actual site.                   
    };
});