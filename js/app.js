$(document).ready(function()
{        
    var xml;
    $.ajaxSetup({async: false});

    $("#login").on('click', function(e){
        var dbms     = $('#dbms_type').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var hostname = $('#hostname').val();
        var database = $('#database').val();
        var port     = $('#port').val();

        var msg = { dbms: dbms, 
                    username: username,
                    password: password,
                    hostname: hostname, 
                    database: database, 
                    port: port,
                    action: 'login'
                    };
        $.post( "login.php", msg, function( data ) {
            console.log( data );
            var result = jQuery.parseJSON(data);
            if (data == -1) {
                alert("No schema in database: " + database);
                return;
            }
            // $('#schema_body').html();
            html = "";
            for (var i = 0; i < result.length; i++) {
                html += "<tr>";
                html += "<td>"+result[i][0]+"</td>";
                html += "<td>"+result[i][1]+"</td>";
                html += "<td>"+result[i][2]+"</td>";
                html += '<td><button href="#" id="select_schema" class="button tiny button-select" value="'+result[i][1]+'" onclick="">Select</button></td>';
                html += "</tr>";
            };
            $('#schema_body').html(html);
            $("#side-form").toggleClass("-hidden-side");
            $("#center-view").toggleClass("-hidden-center");
        });
    });

    $("#dbms_type").on('change', function(e){
        var dbms = $('#dbms_type').val();
        if (dbms == "-") {
            $('#port').val("");
        } else if (dbms == "postgres") {
            $('#port').val("5432");
        } else if (dbms == "mysql") {
            $('#port').val("3306");
        }
    });


    $( document ).on( 'click', '#select_schema', function (e) {
        var msg = { dbms:     $('#dbms_type').val(), 
                    username: $('#username').val(),
                    password: $('#password').val(),
                    hostname: $('#hostname').val(), 
                    database: $('#database').val(), 
                    port:     $('#port').val(),
                    action:   'getxml'
                    };
        $.post( "login.php", msg, function( data ) {
            // console.log( data );
            // var result = jQuery.parseJSON(data);
            if (window.DOMParser) {
                parser = new DOMParser();
                xmlDoc = parser.parseFromString(data,"text/xml");
            }
            else { // Internet Explorer
                xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                xmlDoc.async=false;
                xmlDoc.loadXML(data);
            }
            db_obj   = xmlDoc.getElementsByTagName('database')[0];
            name  = db_obj.attributes[0].value;
            total = db_obj.attributes[1].value;

        html  = '<dd class="accordion-navigation active">';
        html += '<a href="#db-panel"><div class="row">';
        html += '<div class="large-7 columns">Database: '+name+'</div>';
        html += '<div class="large-3 columns">total schema: '+total+'</div>';
        html += '<div class="large-2 columns"><span class="label right">Collapse</span></div>';
        html += '</div></a>';

        html += '<div id="db-panel" class="content active">';
        // html += '<h5>Database <small>name: '+name+' total schema: '+total+'</small></h5>';
        html += '<dl class="accordion" data-accordion="schema-group">';
        sche_obj = xmlDoc.getElementsByTagName('schema');
        for (var i = 0; i < sche_obj.length; i++) {
            name = sche_obj[i].attributes[0].value;
            total = sche_obj[i].attributes[1].value;
            html += '<dd class="accordion-navigation active">';
            html += '<a href="#sc-panel'+i+'"><div class="row">';
            html += '<div class="large-7 columns">Schema: '+name+'</div>';
            html += '<div class="large-3 columns">total table: '+total+'</div>';
            html += '<div class="large-2 columns"><span class="label right">Collapse</span></div>';
            html += '</div></a>';
            html += '<div id="sc-panel'+i+'" class="content active">';
            // html += 'Schema name: '+name+' total table: '+total;
            html += '<dl class="accordion" data-accordion="table-group">';
            table_obj = sche_obj[i].children;
            for (var j = 0; j < table_obj.length; j++) {
                name   = table_obj[j].attributes[0].value;
                total = table_obj[j].attributes[1].value;
                html += '<dd class="accordion-navigation active">';
                html += '<a href="#tb-panel'+i+j+'"><div class="row">';
                html += '<div class="large-7 columns">Table: '+name+'</div>';
                html += '<div class="large-3 columns">total column: '+total+'</div>';
                html += '<div class="large-2 columns"><span class="label right">Collapse</span></div>';
                html += '</div></a>';
                html += '<div id="tb-panel'+i+j+'" class="content active">';
                column_obj = table_obj[i].children;
                console.log(column_obj);
                for (var k = 0; k < column_obj.length; k++) {
                    name   = column_obj[k].innerHTML;
                    type = column_obj[k].attributes[1].value;
                    html += '<div class="row">';
                    html += '<div class="large-7 columns">Column: '+name+'</div>';
                    html += '<div class="large-5 columns">type: '+type+'</div>';
                    html += '</div>';

                    // html +=     "<li>Column name: "+name+" type: "+type+"<kli>";
                };
                html += '</dd>';
            };
            html += '</div>';
            html += '</dd>';
        };
        html += '</dl>';
        html += '</div>';
        html += '</dd>';
        $('.schema-accordion').html(html);
        $(document).foundation();
            
        });
    });


    $(".xxx").on('click', function(e){
        $("#side-form").toggleClass("-hidden-side");
        $("#center-view").toggleClass("-hidden-center");
    });
});

      