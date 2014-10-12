<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<title>DB XML Generator (dev)</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" id="top-nav" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">DB-XML-Generator</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="#">Link</a></li>
        </ul>
        <form class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" size="15">
            <input type="text" class="form-control" placeholder="Pasword" size="15">
            <input type="text" class="form-control" placeholder="Database" size="15">
            <input type="text" class="form-control" placeholder="Port (Default:5432)" size="15" maxlength="5">
          </div>
          <button type="submit" class="btn btn-default">Login</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="container-fluid">
    <div class="table-responsive">
      <table class="table table-hover">
        <tr>
          <td class="active">...</td>
          <td class="success">...</td>
          <td class="warning">...</td>
          <td class="danger">...</td>
          <td class="info">...</td>
        </tr>
        <tr>
          <td class="active">...</td>
          <td class="success">...</td>
          <td class="warning">...</td>
          <td class="danger">...</td>
          <td class="info">...</td>
        </tr>
        <tr>
          <td class="active">...</td>
          <td class="success">...</td>
          <td class="warning">...</td>
          <td class="danger">...</td>
          <td class="info">...</td>
        </tr>
        <tr>
          <td class="active">...</td>
          <td class="success">...</td>
          <td class="warning">...</td>
          <td class="danger">...</td>
          <td class="info">...</td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>

<?php
  require_once('lib/schema2XML.inc.php');
?>