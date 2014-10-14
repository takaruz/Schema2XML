<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Schema2XML | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/doc.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/app.js"></script>
  </head>
  <body>

    <nav class="top-bar" data-topbar="" role="navigation">
      <!-- Title -->
      <ul class="title-area">
        <li class="name"><h1><a href="#">Schema2XML </a></h1></li>

        <!-- Mobile Menu Toggle -->
        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
      </ul>

      <!-- Top Bar Section -->
      
      <section class="top-bar-section">
        <!-- Top Bar Left Nav Elements -->
        <ul class="left"></ul>
        <!-- Top Bar Right Nav Elements -->
        <ul class="right">
          <li class="divider"></li>
          <!-- Anchor -->
          <li><a href="#" class="xxx">Generic Button</a></li>
          <li class="divider"></li>
        </ul>
      </section>
    </nav>

    <div id="side-form" class="large-3 medium-4 columns side-form">
      <div class="hide-for-small">
        <div class="sidebar">
          <h5>Login to database</h5>
      <form id="sider">
        <select id="dbms_type">
          <option value="-" style="text-indent: 5px;">Select DBMSs</option>
          <option value="mysql">Mysql</option>
          <option value="postgres" selected>Postgres</option>
        </select>
        <div class="row collapse">
          <div class="small-3 large-4 columns">
            <span class="prefix">Username</span>
          </div>
          <div class="small-9 large-8 columns">
            <input type="text" id="username" value="thesis">
          </div>
        </div>
        <div class="row collapse">
          <div class="small-3 large-4 columns">
            <span class="prefix">Password</span>
          </div>
          <div class="small-9 large-8 columns">
            <input type="password" id="password" value="123456">
          </div>
        </div>
        <div class="row collapse">
          <div class="small-3 large-4 columns">
            <span class="prefix">Hostname</span>
          </div>
          <div class="small-9 large-8 columns">
            <input type="text" id="hostname" value="master">
          </div>
        </div>
        <div class="row collapse">
          <div class="small-3 large-4 columns">
            <span class="prefix">Port</span>
          </div>
          <div class="small-9 large-8 columns">
            <input type="text" id="port">
          </div>
        </div>
        <div class="row collapse">
          <div class="small-3 large-4 columns">
            <span class="prefix">Database</span>
          </div>
          <div class="small-9 large-8 columns">
            <input type="text" id="database" value="thesis">
          </div>
        </div>
        <div class="row">
          <div class="small-10 small-centered large-centered columns">
            <a href="#" id="login" class="button tiny" style="width: 100%;">Login</a>
          </div>
        </div>

        <div class="hide">
          <select id="tester">
            <option value="-" style="text-indent: 5px;">Select DBMSs</option>
            <option value="mysql">Mysql</option>
            <option value="postgres">Postgres</option>
          </select>
        </div>
      </form>
      </div>
    </div>
    </div>


    <div id="center-view" class="large-9 medium-8 columns center-view -hidden-center">
      <div class="main-div">
        <table id="schema_table" class="show" width="100%">
          <thead>
            <tr>
              <th width="20%">No.</th>
              <th width="35%">Schema name</th>
              <th width="25%">Total table in schema</th>
              <th width="20%">Select Schema</th>
            </tr>
          </thead>
          <tbody id="schema_body">
          </tbody>
        </table>
      </div>
    </div>            
    
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
