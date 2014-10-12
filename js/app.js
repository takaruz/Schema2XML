$(document).ready(function()
{        
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
        			port: port
        			};
        $.post( "login.php", msg, function( data ) {
        	// var result = jQuery.parseJSON(data);
        	// alert( "success "+ result.name );
        	console.log( data );
        	// $("#main-div").append('<pre><code>'+data+'</code></pre>');
        	$("#main-div").append("asdf");
		});
		
		//var select = "<select id=\"tester\"><option value=\"-\" style=\"text-indent: 5px;\">Select DBMSs</option><option value=\"mysql\">Mysql</option><option value=\"postgres\">Postgres</option></select>";
		// $('#sider').append(select);

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

	$("#tester").on('change', function(e){
		alert("asdf");
	});

});
