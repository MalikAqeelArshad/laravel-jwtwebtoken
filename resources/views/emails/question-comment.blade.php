<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Question - Answer</title>
</head>
<body>
	<h1>Dear {{ $user->name }},</h1>

	<p>You'v been recieved the answer regarding your question.</p>

	<p><b>Question:</b> {{ $comment->question->title }}</p>

	<p><b>Answer:</b> {{ $comment->message }}</p>

    <p>Thank you</p>
</body>
</html>