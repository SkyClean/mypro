<?php ?>
<!DOCTYPE HTML>
<!--
	##
	# Example page with embedded Shell In A Box.
	#
	On this page we can see how Shell In A Box can be embedded in another page and
	how can we comunicate with it.
	##
	# Server Side
	#
	For communication with Shell In A Box we need to set '-m' (messages-origin)
	command line option with appropriate messages origin. Origin should be set to
	URL of parent (this) window. If origin is set to '*' Shell In A Box won't check
	origin on received messages. This is usually unsafe option.
	Command line example:
		shellinaboxd -p 4200 -m 'https://192.168.1.150'
	##
	# Client Side
	#
	Shell In A Box accepts messages formatted as JSON strings with 'type' and 'data'
	fields. Messages with same format can be passed back to parent (this) window.
	Message example:
		var message = JSON.stringify({
			type : "message type",
			data : "additional data"
		});
	Messages are passed with function postMessage() and are received in "message"
	events.
	Following types of message can be sent to shellinabox:
	* input
		writes content of data field to terminal
	* output
		enables passing of output to parent window (data field must be set
		to enable, disable or toggle)
	* session
		request sessions status
	* onsessionchange
		enables passing session status to parent window (data field must be
		set to enable, disable or toggle)
	* reconnect
		reconnects the terminal
	Following types of messages can be received from shellinabox:
	* ready
		signals that shellinabox is ready to send and receive messages
	* output
		data field contains terminal output
	* session
		data field contains session status (alive or closed)
	Example for passing command to Shell In A Box frame:
		iframe.contentWindow.postMessage(JSON.stringify({
			type : "input",
			data : "ls -l\n"
		}), "https://192.168.1.150:4200");
	Please note that message passing and JSON operations are only supported on moderen
	browsers.
	##
	# Info
	#
	For working examples please see HTML and JS code bellow...
	For more info and browser limitations on iframe message passing please check:
	https://developer.mozilla.org/en-US/docs/Web/API/Window/postMessage
-->
<html>
<head>
	<style>
		p {
			font-size:	1.1em;
		}
		#shell, #output {
			width:		640px;
			height:		300px;
			margin: 	20px 10px;
		}
		#output {
			overflow:	scroll;
			border:		2px solid #999;
		}
	</style>
</head>
<body>

	<h3>
		Embedded Shell In A Box example page.
	</h3>

	<p>Controls:</p>
	<div>
		<input type="text"   id="input"></input>
		<input type="button" id="execute" value="Execute"></input>
		<input type="button" id="output-enable"  value="Output Enable"></input>
		<input type="button" id="output-disable" value="Output Disable"></input>
		<input type="button" id="reconnect" value="Reconnect"></input>
		<input type="button" id="session-reload" value="Session Status"></input>
		<input type="button" id="session-toggle" value="Session Status Toggle"></input>
	</div>

	<p id="session">Session status: ???</p>

	<!--
		Embedded shellinabox. In our case src attribute will be added with help
		of JS. -->
	<iframe id="shell" src=""></iframe>

	<!-- Ouput -->
	<p>Terminal output:</p>
	<pre id="output"></pre>

	<script>
		// Shellinabox url
		var url = "https://webssh.bartlweb.net";
		var input   = document.getElementById("input");
		var iframe  = document.getElementById("shell");
		var output  = document.getElementById("output");
		var session = document.getElementById("session");
		document.getElementById("execute").addEventListener("click", function() {
			// Send input to shellinabox
			var message = JSON.stringify({
				type : 'input',
				data : input.value + '\n'
			});
			iframe.contentWindow.postMessage(message, url);
		});
		document.getElementById("output-enable").addEventListener("click", function() {
			// Enable output replay from shellinabox iframe
			var message = JSON.stringify({
				type : 'output',
				data : 'enable'
			});
			iframe.contentWindow.postMessage(message, url);
		});
		document.getElementById("output-disable").addEventListener("click", function() {
			// Disable output replay from shellinabox iframe
			var message = JSON.stringify({
				type : 'output',
				data : 'disable'
			});
			iframe.contentWindow.postMessage(message, url);
			// Clear output window
			output.innerHTML = '';
		});
		document.getElementById("session-reload").addEventListener("click", function() {
			// Request shellianbox session status
			var message = JSON.stringify({
				type : 'session'
			});
			iframe.contentWindow.postMessage(message, url);
		});
		document.getElementById("session-toggle").addEventListener("click", function() {
			// Toggles shellinabox session status reporting
			var message = JSON.stringify({
				type : 'onsessionchange',
				data : 'toggle'
			});
			iframe.contentWindow.postMessage(message, url);
		});
		document.getElementById("reconnect").addEventListener("click", function() {
			// Request shellianbox session status
			console.log('reconnect');
			var message = JSON.stringify({
				type : 'reconnect'
			});
			iframe.contentWindow.postMessage(message, url);
		});
		// Receive response from shellinabox
		window.addEventListener("message", function(message) {
			// Allow messages only from shellinabox
			if (message.origin !== url) {
				return;
			}
			// Handle response according to response type
			var decoded = JSON.parse(message.data);
			switch (decoded.type) {
			case "ready":
				// Shellinabox is ready to communicate and we will enable console output
				// by default.
				var message = JSON.stringify({
					type : 'output',
					data : 'enable'
				});
				iframe.contentWindow.postMessage(message, url);
				break;
			case "output" :
				// Append new output
				output.innerHTML = output.innerHTML + decoded.data;
				break;
			case "session" :
				// Reload session status
				session.innerHTML = 'Session status: ' + decoded.data;
				break;
			}
		}, false);
		// Add url to our iframe after the event listener is installed.
		iframe.src = url;
	</script>

</body>
</html>
