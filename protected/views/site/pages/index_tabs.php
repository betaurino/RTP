<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Tabs Example</title>

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
  <script src="ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>

  <script src="js/tabs.js"></script>
  
  <style>
    #dialog label, #dialog input { display:block; }
    #dialog label { margin-top: 0.5em; }
    #dialog input, #dialog textarea { width: 95%; }
    #tabs { margin-top: 1em; }
    #tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
    #add_tab { cursor: pointer; }

    div.transbox
    {
    display:inline-block;
    width:auto;
    height:18px;
    background-color:#6633FF;
    border:1px solid black;
    opacity:0.6;
    filter:alpha(opacity=60); /* For IE8 and earlier */
    z-index: 5;
    }

    div.transbox p
    {
    color: white; 
    text-shadow: black 0.1em 0.1em 0.2em;
    padding: 2px;
    margin: 0px;
    }

  </style>
</head>

<body id="body">



<!-- All the editors -->
<div id="dialog" title="Tab data">
  <form>
    <fieldset class="ui-helper-reset">
      <label for="tab_title">Name</label>
      <input type="text" name="tab_title" id="tab_title" value="" class="ui-widget-content ui-corner-all">
    </fieldset>
  </form>
</div>
 
<button id="add_tab">Add Tab</button>

<div id="tabs">
  <ul id="tabUL">
  </ul>
</div>
</body>
</html>