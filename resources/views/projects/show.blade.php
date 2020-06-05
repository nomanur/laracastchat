<!DOCTYPE html>
<html>
<head>
	<title>show</title>

	  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    	<script type="text/javascript">
    		window.App = <?php echo json_encode(['user'=> auth()->user() ]); ?>
    	</script>
</head>
<body>

	
	<h2>Pusher Real time chat</h2>
	<h3>{{Auth::user()->name}}</h3>
	<div id="app">
		<task-list :dataproject='{{$project}}'></task-list>
	</div>

			

	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>