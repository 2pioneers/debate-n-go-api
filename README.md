Debate-n-go
===========

This is the temporary rest point service for the debate-n-go api

Author: [Justin Walrath](mailto:walrathjaw@gmail.com)

###REST API
#####Login
	$.ajax({
		type: "GET",
		url: "http://url.com/login/<sample-unique-url>",
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});

#####Update username
	sendData = { user_id: "<crazyLongUserId>", new_username: "<newUsername>" };

	$.ajax({
		type: "POST",
		url: "http://url.com/updateUsername/"
		data: JSON.stringify(sendData),
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});

#####Place a vote
	sendData = { user_id: "<crazyLongUserId>", option_id: "<option id>", vote_options: <array of the vote options> };

	$.ajax({
		type: "POST",
		url: "http://url.com/userVote/"
		data: JSON.stringify(sendData),
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});

#####Leave a root parent comment
	sendData = { user_id: "<crazyLongUserId>", title: "The tagline/title of the message", message: "The message", vote_options: <array of the vote options>, vote_topic_id: "<topic id>" };

	$.ajax({
		type: "POST",
		url: "http://url.com/leaveComment/"
		data: JSON.stringify(sendData),
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});

#####Leave a child reply
	sendData = { user_id: "<crazyLongUserId>", message: "The message", parent_id: "parentID" };

	$.ajax({
		type: "POST",
		url: "http://url.com/leaveReply/"
		data: JSON.stringify(sendData),
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});
	
#####Get all messages for topic id
	sendData = { user_id: "<crazyLongUserId>", vote_topic_id: "<topic id>" };

	$.ajax({
		type: "POST",
		url: "http://url.com/refreshMessages/"
		data: JSON.stringify(sendData),
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});
	
#####Get all messages for topic option
	sendData = { user_id: "<crazyLongUserId>", option_id: "<option id>" };

	$.ajax({
		type: "POST",
		url: "http://url.com/refreshOptionMessageKeys/"
		data: JSON.stringify(sendData),
		contentType: "application/json",
		success: function(data, textStatus, jqXHR) {
			//Process the results here.
		}
	});

###Testing
####Run Unit tests
1. Load the database from below.
2. Run php vendor/bin/phpunit.
3. Watch the green show up (Hopefully)

###Loading the test data
####Linux
To import the code:

	./example-data/IMPORT.sh

####Windows
You will need to run each command found in example-data/IMPORT.sh from the command line to load the data into the mongodb.
