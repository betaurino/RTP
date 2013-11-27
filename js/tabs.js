$(document).ready(function() {
    var currentEditor;
    var editors = [];
    var tabTitle = $( "#tab_title" );
    var tabContent = $( "#tab_content" );
    var tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>";
    var tabs = $( "#tabs" ).tabs();
    
    // add  and open the first editor
    tabTitle.val("main.c");
    tabCounter = 1;
    addTab();
    tabTitle.val("");
 
    // modal dialog init: custom buttons and a "close" callback reseting the form inside
    var dialog = $( "#dialog" ).dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Add: function() {
          addTab();
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
      }
    });

    // addTab form: calls addTab function on submit and closes the dialog
    var form = dialog.find( "form" ).submit(function( event ) {
      addTab();
      dialog.dialog( "close" );
      event.preventDefault();
    });

    // actual addTab function: adds new tab using the input from the form above
    function addTab() {

      var label = tabTitle.val() || "Tab " + tabCounter,
          Tabid = "tabs-" + tabCounter,
          li = $( tabTemplate.replace( /#\{href\}/g, "#" + Tabid ).replace( /#\{label\}/g, label ) ),
          tabContentHtml = '<div id=editor_'+tabCounter+'>add some code here</div>';

      tabs.find(".ui-tabs-nav").append( li );
      tabs.append( "<div id='" + Tabid + "'>" + tabContentHtml + "</div>" );
      tabs.tabs( "refresh" );

      var newEditorElement = $("#editor_"+tabCounter);
      newEditorElement.width('850');
      newEditorElement.height('480');

      
      var editor = ace.edit('editor_'+tabCounter);
      editor.setTheme("ace/theme/monokai");
      editor.getSession().setMode("ace/mode/c_cpp");

      editor.resize();
      editors.push({ id: Tabid, instance: editor });
      currentEditor = editor;
      tabCounter++;
      $('#tabUL a[href="#'+Tabid+'"]').trigger('click');
    }
 
    // addTab button: just opens the dialog
    $( "#add_tab" )
      .button()
      .click(function() {
        dialog.dialog( "open" );
      });
 
    // close icon: removing the tab on click
    tabs.delegate( "span.ui-icon-close", "click", function() {
      var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
      $( "#" + panelId ).remove();
      tabs.tabs( "refresh" );
    });
 
    tabs.bind( "keyup", function( event ) {
      if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
        var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        tabs.tabs( "refresh" );
      }
    });

    


    //Over Name Image
    changeNamePosition();

    $( ".ace_text-input" ).keyup(function() {
      changeNamePosition();
    });

     $( ".ace_text-input" ).keydown(function() {
      changeNamePosition();
    });
    
    $("#editor_1").click(function() {                            
      changeNamePosition();          
    });

    function changeNamePosition(){
      var elemento = $(".ace_cursor");
      var posicion = elemento.offset();
      $("#b1").offset({top:posicion.top-16,left:posicion.left});
     }

});



















