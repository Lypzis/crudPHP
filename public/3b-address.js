// This script uses AJAX to send POST requests to the server for processing.
var ab = {
	// The backbone of the CRUD functions. Sends and AJAX request to the server
	// and handles the response.
	ajax: function (data, after) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', "2c-ajax-address.php", true);
		xhr.onload = function () {
      if (xhr.status==403 || xhr.status==404) {
        alert("ERROR LOADING FILE");
      } else {
        var res = JSON.parse(this.response);
        if (after !== undefined) { after(res); }
      }
		};
		xhr.send(data);
	},

	// This is used to show the add/edit address entry form when the user
	// clicks on an address entry
	prime: function (id) {
		document.getElementById("ab_form_head").innerHTML = id==0 ? "Add Entry" : "Edit Entry" ;
		document.getElementById("form_id").value = id==0 ? "" : id ;
		document.getElementById("form_address").value = id==0 ? "" : document.getElementById("addr"+id).innerHTML ;
		document.getElementById("btn_save").onclick = id==0 ? ab.create : ab.update ;
		document.getElementById("ab_form").style.display = "block";
	},

	// Handles adding new address book entries.
	create: function () {
		var data = new FormData();
		data.append('req', 'create');
		data.append('address', document.getElementById("form_address").value);
		ab.ajax(data, function(res){
			var message = "";
			if (res.status == true) {
				message += "<div class='container green'>";
				ab.read();
			} else {
				message += "<div class='container red'>";
			}
			message += res.message + "</div>";
			document.getElementById("ab_msg").innerHTML = message;
			document.getElementById("ab_form").style.display = "none";
		});
	},

	// Grabs address book entries from the server and displays them into 
	// an html table.
	read: function () {
		document.getElementById("addresses").innerHTML = "";
		var data = new FormData();
		data.append('req', 'read');
		ab.ajax(data, function (res) {
			if (res.data == null) {
				document.getElementById("addresses").innerHTML = "No entries found";
			} else {
				var list = "<table>";
				for (var i = 0; i < res.data.length; i++) {
					list += "<tr><td id='addr" + res.data[i]['id'] + "'>" + res.data[i]['address'] + "</td>";
					list += "<td><input type='button' class='red' value='Delete' onclick='ab.delete(" + res.data[i]['id'] + ")'/>";
					list += " <input type='button' class='green' value='Edit' onclick='ab.prime(" + res.data[i]['id'] + ")'/></td></tr>";
				}
				list += "</table>";
				document.getElementById("addresses").innerHTML = list;
			}
		});
	},

	// Updates an address book entry.
	update: function () {
		var data = new FormData();
		data.append('req', 'update');
		data.append('id', document.getElementById("form_id").value);
		data.append('address', document.getElementById("form_address").value);
		ab.ajax(data, function(res){
			var message = "";
			if (res.status == true) {
				message += "<div class='container green'>";
				ab.read();
			} else {
				message += "<div class='container red'>";
			}
			message += res.message + "</div>";
			document.getElementById("ab_msg").innerHTML = message;
			document.getElementById("ab_form").style.display = "none";
		});
	},

	// Deletes an address book entry
	delete: function (id) {
		var data = new FormData();
		data.append('req', 'delete');
		data.append('id', id);
		ab.ajax(data, function(res){
			var message = "";
			if (res.status == true) {
				message += "<div class='container green'>";
				ab.read();
			} else {
				message += "<div class='container red'>";
			}
			message += res.message + "</div>";
			document.getElementById("ab_msg").innerHTML = message;
			document.getElementById("ab_form").style.display = "none";
		});
	}
};

window.addEventListener("load", ab.read);