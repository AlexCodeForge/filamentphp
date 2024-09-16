<!DOCTYPE html>
<html>
<head>
	<title>Export Request</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f7f7f7;
		}
		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0,0,0,0.1);
		}
		table {
			border-collapse: collapse;
			width: 100%;
		}
		th, td {
			border: 1px solid #ddd;
			padding: 10px;
			text-align: left;
		}
		th {
			background-color: #f2f2f2;
		}
		.button {
			background-color: #666;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
		}
		.button:hover {
			background-color: #777;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>File Request</h2>
		<table>
			<tr>
				<th>Request Details</th>
				<td>
					<table>
						<tr>
							<th>User:</th>
							<td>{{ auth()->user()->name }}</td>
						</tr>
						<tr>
							<th>Your requested file:</th>
							<td>
                            <a class="button" href="{{ $url }}">Download</a>

                            </td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
