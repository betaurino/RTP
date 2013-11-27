<!DOCTYPE html>
<html>
<head>             
   <?php
    /* @var $this SiteController */
    $this->pageTitle=Yii::app()->name;
   ?>
   <style type="text/css" media="screen">
      #editor 
      { 
         margin-top: 40px;
         height:  420px;
         bottom:  20px;
      }
  </style>
</head>

<body>
<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<p>Bienvenidos Putos !!! al primer programador colectivo </p>

<div id="editor">//Fibbonacci recursive version C
   
unsigned int fib(unsigned int n){
   return (n < 2) ? n : fib(n - 1) + fib(n - 2);
}</div>

<script src="ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>

<script src='https://cdn.firebase.com/v0/firebase.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'></script> 

<script>
    
    var myDataRef = new Firebase('https://rtp.firebaseio.com/');      
    var writer = false;    
    var selectedRange = null;
    
    var prevCursor = null;
    var cursor = null;
    
    var Range = ace.require('ace/range').Range;
    
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/twilight");
    editor.getSession().setMode("ace/mode/c_cpp");
        
    editor.selection.on("changeCursor", function() {
        prevCursor = cursor;
        cursor = editor.selection.getCursor();
        
        console.log(prevCursor.column);
        console.log(cursor.column);
    });
        
    
    function sendData(key) {
        
        var range;

        if(selectedRange === null) { // No selection performed
            
            var srow = cursor.row;
            var scol = cursor.column;
            
            if(key === 8) { // Erasing 
                var erow = prevCursor.row; // Checking if erasing a tab
                var ecol = prevCursor.column;
                
                range = new Range(srow, scol, erow, ecol); 
            } else {  // Erasing just one space                              
                range = new Range(srow, scol, srow, scol+1); 
            }                                        
        } else { 
            var srow = selectedRange.start.row;
            var scol = selectedRange.start.column;
            var erow = selectedRange.end.row;
            var ecol = selectedRange.end.column;
            
            range = new Range(srow, scol, erow, ecol);            
        }                                                                         
        writer = true;                                  
        myDataRef.push({range: range, key: key});    
        
        selectedRange = null;
    }       
    
    
    myDataRef.on('child_added', function(snapshot) {
                                
        var sentObject = snapshot.val();            
        var key = sentObject.key; // Key pressed 
        
        var range = sentObject.range; // Getting range         
        var srow = range.start.row;   // Getting range stuff    
        var scol = range.start.column;
        var erow = range.end.row;
        var ecol = range.end.column;
                                                     
        if(writer === false) { 
                            
            if(key === 8) { // Erasing range                                                
                editor.getSession().remove(new Range(srow, scol, erow, ecol));                
            } else {        // Insert a key    
                if(srow !== erow || scol !== (ecol-1) && key !== 9) { // Remove range selected                    
                    editor.getSession().remove(new Range(srow, scol, erow, ecol));
                }                
                // Insert the key                
                var c;
                if(key === 9) {  // Getting the Tab character                 
                    c = editor.getSession().getTabString();
                    // Point to the start of the Tab
                    scol -= editor.getSession().getTabSize(); 
                } else {
                    c = String.fromCharCode(key); // Normal character
                }                
                editor.getSession().insert({row: srow, column: scol}, c); // Insert               
            } 
        }                                            
        writer = false;
    });
    
    $("#editor").click(function() {        
        setSelectionRange();            
    });
    
    $(".ace_text-input").keyup(function(evnt){ // Shift selection
        var ev = (evnt) ? evnt : event;
        var code = (ev.which) ? ev.which : event.keyCode;  

        if(code === 16) // Shift key
            setSelectionRange();           
    });
            
    $(".ace_text-input").keydown(function(evnt){ // Special characters
        var ev = (evnt) ? evnt : event;
        var code = (ev.which) ? ev.which : event.keyCode;                  
        
        // Erase         Tab
        if(code === 8 || code === 9) {            
            sendData(code);            
        }            
    });
    
    $(".ace_text-input").keypress(function(evnt){ // Characters
        var ev = (evnt) ? evnt : event;
        var code = (ev.which) ? ev.which : event.keyCode;
                
        if(code !== 9) // Do not send Tab
            sendData(code);            
    });
    
    function setSelectionRange() {
        selectedRange = editor.getSelectionRange();
                        
        // No range selected
        if(selectedRange.start.row === selectedRange.end.row 
                && selectedRange.start.column === selectedRange.end.column) {
            selectedRange = null;
        }  
    }
    
    
</script>



</body>
</html>
