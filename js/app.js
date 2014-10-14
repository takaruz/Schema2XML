$(document).ready(function()
{        
    var xml;

    $("#login").on('click', function(e){
    	var dbms 	 = $('#dbms_type').val();
    	var username = $('#username').val();
    	var password = $('#password').val();
    	var hostname = $('#hostname').val();
    	var database = $('#database').val();
    	var port 	 = $('#port').val();

        var msg = {	dbms: dbms, 
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
            
        	console.log( result[0] );
            if (data == -1) {
                alert("No schema in database: " + database);
                return;
            }
            for (var i = 0; i < result.length; i++) {
                var html  = "<tr>";
                    html += "<td>"+result[i][0]+"</td>";
                    html += "<td>"+result[i][1]+"</td>";
                    html += "<td>"+result[i][2]+"</td>";
                    html += '<td><button href="#" id="select_schema" class="button tiny button-select" value="'+result[i][1]+'" onclick="test()">Select</button></td>';
                    html += "</tr>";
                $('#schema_body').append(html);
            };
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

/*
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
            console.log( data );
            // var result = jQuery.parseJSON(data);
            // console.log( result[0] );
            $('.main-div').append('xxxx');
        });
    });
*/


    $.when(test()).done(function(e){
        $('.main-div').append(xml);
    });

    $(".xxx").on('click', function(e){
        $("#side-form").toggleClass("-hidden-side");
        $("#center-view").toggleClass("-hidden-center");
    });

    function test() {
        var msg = { dbms:     $('#dbms_type').val(), 
                    username: $('#username').val(),
                    password: $('#password').val(),
                    hostname: $('#hostname').val(), 
                    database: $('#database').val(), 
                    port:     $('#port').val(),
                    action:   'getxml'
                    };
        $.post( "login.php", msg, function( data ) {
            console.log( data );
            xml = data;
            // var result = jQuery.parseJSON(data);
            // console.log( result[0] );
            // $('.main-div').append('xxxx');
        });
    }

});


