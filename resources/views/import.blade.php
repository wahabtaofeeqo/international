<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form action="test" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="file" name="file" required><br>
		<button>Post</button>
	</form>
</body>
</html>